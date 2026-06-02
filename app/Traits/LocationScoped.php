<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Restricts a model's listing queries to the locations assigned to the
 * currently authenticated staff member.
 *
 * Usage in a controller listing: Model::forCurrentUser()->latest()->get();
 *
 * Visibility rules (decision centralized in scopeForCurrentUser):
 *  - Guest / admin / non-staff user  -> all rows (unfiltered).
 *  - Staff user                      -> only rows tied to their assigned locations.
 *  - Staff user with no locations    -> no rows (fail closed).
 *
 * Each model declares how it reaches a location (first match wins):
 *  - $locationViaRelation : nested relation ending in `locations` (e.g. 'party.locations').
 *  - $locationRelation    : many-to-many relation named `locations`.
 *  - $locationColumn      : direct foreign key column (defaults to 'location_id').
 */
trait LocationScoped
{
    public function scopeForCurrentUser(Builder $query): Builder
    {
        $user = Auth::user();

        // Guest, non-staff, or admin -> all rows.
        if (! $user || ! $user->isStaff() || ! $user->staff || $user->hasRole(Role::ADMIN)) {
            return $query;
        }

        $locationIds = $user->staff->locations()->pluck('locations.id')->all();

        // Fail closed: a staff member with no assigned locations sees nothing.
        if (empty($locationIds)) {
            return $query->whereRaw('1 = 0');
        }

        return $this->applyLocationConstraint($query, $locationIds);
    }

    protected function applyLocationConstraint(Builder $query, array $locationIds): Builder
    {
        if (property_exists($this, 'locationViaRelation') && $this->locationViaRelation) {
            return $query->whereHas(
                $this->locationViaRelation,
                fn ($q) => $q->whereIn('locations.id', $locationIds)
            );
        }

        if (property_exists($this, 'locationRelation') && $this->locationRelation) {
            return $query->whereHas(
                $this->locationRelation,
                fn ($q) => $q->whereIn('locations.id', $locationIds)
            );
        }

        $column = property_exists($this, 'locationColumn') && $this->locationColumn
            ? $this->locationColumn
            : 'location_id';

        return $query->whereIn($query->getModel()->getTable() . '.' . $column, $locationIds);
    }
}

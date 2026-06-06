/**
 * Central registry of every backend module the mobile app exposes.
 *
 * One entry per Laravel `apiResource`. The generic List / Detail / Form
 * screens render entirely from this config, so adding a field or a module
 * is a data change here — no new screen code.
 *
 * Field lists are taken verbatim from each Eloquent model's $fillable.
 */

export type FieldType =
  | 'text'
  | 'number'
  | 'textarea'
  | 'date'
  | 'boolean'
  | 'password'
  | 'relation';

export interface ModuleField {
  name: string;
  label: string;
  type: FieldType;
  required?: boolean;
  relation?: { endpoint: string; labelKeys: string[] };
}

export interface ModuleDef {
  key: string;
  endpoint: string;
  title: string;
  group: string;
  icon: string;
  /** Field names tried, in order, to render a record's row title. */
  titleKeys: string[];
  fields: ModuleField[];
}

// field name -> related module endpoint + candidate label columns
const RELATIONS: Record<string, { endpoint: string; labelKeys: string[] }> = {
  department_id: { endpoint: 'departments', labelKeys: ['name'] },
  subdepartment_id: { endpoint: 'sub-departments', labelKeys: ['name'] },
  division_id: { endpoint: 'division', labelKeys: ['name'] },
  sub_division_id: { endpoint: 'sub-division', labelKeys: ['name'] },
  firm_id: { endpoint: 'firms', labelKeys: ['name'] },
  location_id: { endpoint: 'locations', labelKeys: ['name'] },
  work_id: { endpoint: 'works', labelKeys: ['name_of_work', 'name'] },
  staff_id: { endpoint: 'staff', labelKeys: ['first_name', 'code'] },
  user_id: { endpoint: 'users', labelKeys: ['name', 'email'] },
  party_id: { endpoint: 'parties', labelKeys: ['name'] },
  vendor_id: { endpoint: 'contractors', labelKeys: ['pedhi', 'contact_person'] },
  contractor_id: { endpoint: 'contractors', labelKeys: ['pedhi', 'contact_person'] },
  material_category_id: { endpoint: 'material-categories', labelKeys: ['name'] },
  material_id: { endpoint: 'material-lists', labelKeys: ['name'] },
  stage_id: { endpoint: 'stages', labelKeys: ['name'] },
  role_id: { endpoint: 'roles', labelKeys: ['name'] },
  work_order_id: { endpoint: 'work-orders', labelKeys: ['work_order_number'] },
};

const NUMERIC = /(amount|price|percentage|qty|quantity|rate|cost|total|paid|value|sequence|no_of|bhadu|salary|expense|bill_payable|deduction|received)/;
const LONGTEXT = /(address|remark|description|condition_text|reason_of|note|list_of_material|subject|payment_condition)/;
const DATEISH = /(date|dob|doj)/;
const REQUIRED = new Set(['name', 'name_of_work', 'first_name', 'email']);

function humanize(name: string): string {
  return name
    .replace(/_id$/, '')
    .replace(/_/g, ' ')
    .replace(/\b\w/g, (c) => c.toUpperCase())
    .replace(/\bGst\b/, 'GST')
    .replace(/\bPan\b/, 'PAN')
    .replace(/\bIfsc\b/, 'IFSC')
    .replace(/\bNo\b/, 'No.')
    .replace(/\bUan\b/, 'UAN')
    .replace(/\bEsic\b/, 'ESIC');
}

function field(name: string): ModuleField {
  const base = { name, label: humanize(name), required: REQUIRED.has(name) };
  if (RELATIONS[name]) return { ...base, type: 'relation', relation: RELATIONS[name] };
  if (name === 'password') return { ...base, type: 'password' };
  if (name === 'is_staff') return { ...base, type: 'boolean' };
  if (DATEISH.test(name)) return { ...base, type: 'date' };
  if (NUMERIC.test(name)) return { ...base, type: 'number' };
  if (LONGTEXT.test(name)) return { ...base, type: 'textarea' };
  return { ...base, type: 'text' };
}

function def(
  m: Omit<ModuleDef, 'fields' | 'titleKeys'> & {
    titleKeys?: string[];
    fieldNames: string[];
  },
): ModuleDef {
  return {
    key: m.key,
    endpoint: m.endpoint,
    title: m.title,
    group: m.group,
    icon: m.icon,
    titleKeys: m.titleKeys ?? ['name'],
    fields: m.fieldNames.map(field),
  };
}

export const MODULES: ModuleDef[] = [
  // ----- Org structure -----
  def({ key: 'departments', endpoint: 'departments', title: 'Departments', group: 'Org Structure', icon: '🏛️', fieldNames: ['name'] }),
  def({ key: 'sub-departments', endpoint: 'sub-departments', title: 'Sub Departments', group: 'Org Structure', icon: '🏢', fieldNames: ['name', 'department_id'] }),
  def({ key: 'division', endpoint: 'division', title: 'Divisions', group: 'Org Structure', icon: '🗂️', fieldNames: ['name', 'department_id', 'subdepartment_id', 'head_of_division_name', 'address', 'head_mobile_number', 'contact_number', 'contact_person_name', 'contact_person_mobile_number', 'bank_name', 'bank_account_no', 'ifsc_code'] }),
  def({ key: 'sub-division', endpoint: 'sub-division', title: 'Sub Divisions', group: 'Org Structure', icon: '🗃️', fieldNames: ['name', 'division_id', 'head_of_sub_division', 'address', 'name_of_sub_div_head', 'head_mobile_number', 'sub_div_contact_person_name', 'contact_person_name', 'contact_person_mobile_number', 'remark'] }),
  def({ key: 'pedhi', endpoint: 'pedhi', title: 'Pedhi', group: 'Org Structure', icon: '📒', fieldNames: ['name'] }),
  def({ key: 'firms', endpoint: 'firms', title: 'Firms', group: 'Org Structure', icon: '🏦', fieldNames: ['name', 'address', 'pancard', 'gst', 'pf_code', 'mobile_number', 'email', 'bank_name', 'bank_account_no', 'ifsc_code', 'head_name', 'head_mobile_number', 'remark'] }),
  def({ key: 'locations', endpoint: 'locations', title: 'Locations', group: 'Org Structure', icon: '📍', fieldNames: ['name', 'firm_id', 'department_id', 'subdepartment_id', 'division_id', 'sub_division_id', 'remark'] }),
  def({ key: 'works', endpoint: 'works', title: 'Works', group: 'Org Structure', icon: '🚧', titleKeys: ['name_of_work'], fieldNames: ['name_of_work', 'firm_id', 'department_id', 'subdepartment_id', 'division_id', 'sub_division_id', 'location_id', 'description_of_work', 'tender_id', 'estimate_cost', 'equal_above_below_on_estimate', 'final_amt_of_work', 'add_18_percent_gst', 'gst_amount', 'our_final_work_amt', 'time_limit_years_months', 'work_order_no', 'wo_date', 'end_date_of_work', 'work_start_date', 'if_extend_date', 'extended_date'] }),

  // ----- HR / Labour -----
  def({ key: 'staff', endpoint: 'staff', title: 'Staff', group: 'HR & Labour', icon: '👷', titleKeys: ['first_name', 'code'], fieldNames: ['code', 'first_name', 'second_name', 'last_name', 'user_id', 'dob', 'doj', 'designation', 'permanent_address', 'present_address', 'mobile_number', 'other_contact_number', 'relative_name', 'relation', 'relative_mobile_no', 'gender', 'marital_status', 'blood_group', 'aadhar_no', 'pan_no', 'uan_no', 'esic_no', 'bank_name', 'bank_account_no', 'ifsc_code', 'date_of_leaving', 'no_of_years_service', 'rate_per_day', 'rate_per_month', 'salary_date', 'remark'] }),
  def({ key: 'daily-expense', endpoint: 'daily-expense', title: 'Daily Expense', group: 'HR & Labour', icon: '🧾', titleKeys: ['description'], fieldNames: ['staff_id', 'location_id', 'date', 'amount', 'description', 'remark'] }),

  // ----- Procurement / Materials -----
  def({ key: 'parties', endpoint: 'parties', title: 'Parties', group: 'Procurement', icon: '🤝', fieldNames: ['name', 'firm_id', 'gst', 'pancard', 'address', 'mobile', 'contact_person_name', 'contact_person_mobile', 'list_of_material', 'bank_account_holder_name', 'bank_name_branch', 'bank_account_no', 'ifsc_code', 'remark'] }),
  def({ key: 'contractors', endpoint: 'contractors', title: 'Contractors', group: 'Procurement', icon: '🛠️', titleKeys: ['pedhi', 'contact_person'], fieldNames: ['pedhi', 'gst', 'pan', 'bank_name', 'ifsc', 'branch_name', 'bank_account_no', 'address', 'mobile', 'contact_person', 'contact_person_mobile', 'ref_by', 'ref_cont_no', 'payment_term', 'amount', 'remaining_amount'] }),
  def({ key: 'material-categories', endpoint: 'material-categories', title: 'Material Categories', group: 'Procurement', icon: '🏷️', fieldNames: ['name'] }),
  def({ key: 'material-lists', endpoint: 'material-lists', title: 'Material List', group: 'Procurement', icon: '📦', fieldNames: ['name', 'material_category_id', 'unit', 'remark'] }),
  def({ key: 'site-material-requirements', endpoint: 'site-material-requirements', title: 'Material Requirements', group: 'Procurement', icon: '📋', titleKeys: ['id'], fieldNames: ['location_id', 'work_id'] }),
  def({ key: 'material-inwards', endpoint: 'material-inwards', title: 'Material Inward', group: 'Procurement', icon: '📥', titleKeys: ['bill_voucher_number'], fieldNames: ['location_id', 'work_id', 'party_id', 'party_gst', 'party_pan', 'bill_voucher_type', 'bill_voucher_number', 'bill_voucher_date', 'material_inward_at_site_date', 'add_bhadu', 'total_bill_voucher_amount', 'payment_status', 'payment_ref_number', 'payment_date', 'payment_remarks', 'remarks'] }),

  // ----- Site Ops -----
  def({ key: 'site-progress', endpoint: 'site-progress', title: 'Site Progress', group: 'Site Ops', icon: '📈', titleKeys: ['work_name'], fieldNames: ['location_id', 'work_id', 'work_name', 'work_site', 'stage_id', 'work_stage', 'stage_percentage', 'date', 'remark'] }),
  def({ key: 'stages', endpoint: 'stages', title: 'Stages', group: 'Site Ops', icon: '🪜', fieldNames: ['name', 'percentage', 'location_id', 'work_id'] }),
  def({ key: 'tool-lists', endpoint: 'tool-lists', title: 'Tools', group: 'Site Ops', icon: '🔧', fieldNames: ['name', 'location_id', 'shelf_location', 'quantity', 'person_name', 'date', 'price', 'remark'] }),
  def({ key: 'scrap-materials', endpoint: 'scrap-materials', title: 'Scrap Materials', group: 'Site Ops', icon: '♻️', fieldNames: ['name', 'price', 'date'] }),
  def({ key: 'scrap-lists', endpoint: 'scrap-lists', title: 'Scrap List', group: 'Site Ops', icon: '🗑️', titleKeys: ['feriya'], fieldNames: ['feriya', 'material_id', 'date', 'unit', 'quantity', 'where_place', 'labour_of_scrape', 'remark'] }),

  // ----- Billing & Money -----
  def({ key: 'bill-inwards', endpoint: 'bill-inwards', title: 'Bill Inward', group: 'Billing & Money', icon: '🧮', titleKeys: ['bill_number'], fieldNames: ['firm_id', 'party_id', 'party_gst', 'party_pan', 'bill_number', 'bill_date', 'add_bhadu_labour', 'total_bill_amount', 'payment_status', 'payment_ref_number', 'payment_date', 'payment_remarks', 'remarks'] }),
  def({ key: 'bill-outwards', endpoint: 'bill-outwards', title: 'Bill Outward', group: 'Billing & Money', icon: '💸', titleKeys: ['bill_number'], fieldNames: ['firm_id', 'firm_gst', 'bill_number', 'bill_date', 'party_id', 'party_gst', 'party_address', 'add_bhadu_labour', 'total_bill_amount', 'sd_percentage', 'tds_percentage', 'gst_deduction_percentage', 'lc_percentage', 'tc_percentage', 'total_deduction', 'net_received_amount', 'payment_status', 'payment_ref_number', 'payment_date', 'payment_remarks', 'remarks'] }),
  def({ key: 'payments', endpoint: 'payments', title: 'Payments', group: 'Billing & Money', icon: '💰', titleKeys: ['ref_number', 'reason_of_payment'], fieldNames: ['payment_type', 'staff_id', 'party_id', 'vendor_id', 'work_order_id', 'salary_payable', 'expense_payable', 'total_payable', 'reason_of_payment', 'reason_bill_no', 'bill_payable', 'amount_payable', 'tds_percentage', 'total_deduction', 'paid_amount', 'ref_number', 'payment_date', 'remarks'] }),
  def({ key: 'work-orders', endpoint: 'work-orders', title: 'Work Orders', group: 'Billing & Money', icon: '📑', titleKeys: ['work_order_number'], fieldNames: ['work_order_number', 'order_date', 'contractor_id', 'location_id', 'work_id', 'subject', 'condition_text', 'total_order_value', 'time_limit_for_work', 'payment_condition'] }),

  // ----- Admin -----
  def({ key: 'users', endpoint: 'users', title: 'Users', group: 'Admin', icon: '👤', fieldNames: ['name', 'email', 'password', 'phone', 'is_staff', 'role_id', 'dob', 'address'] }),
  def({ key: 'roles', endpoint: 'roles', title: 'Roles', group: 'Admin', icon: '🛡️', fieldNames: ['name'] }),
];

export const MODULE_GROUPS = [...new Set(MODULES.map((m) => m.group))];

export const getModule = (key: string) => MODULES.find((m) => m.key === key);

/** Best-effort display title for a record using the module's titleKeys. */
export function recordTitle(mod: ModuleDef, row: any): string {
  for (const k of mod.titleKeys) {
    if (row?.[k] != null && row[k] !== '') return String(row[k]);
  }
  return row?.name ?? `#${row?.id ?? ''}`;
}

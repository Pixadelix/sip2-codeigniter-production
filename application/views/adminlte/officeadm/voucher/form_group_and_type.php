<?php

echo form_open('/officeadm/voucher_manager/do_import');

//$types = Model\Voucher_type::select(array('id', 'type'))->result()->all()->to_array();
$ci =& get_instance();
$types = $ci->db->from('sip_voucher_type')
    ->select('id, type, desc')
    ->get()
    ->result_array();
$opt_types = array();
foreach( $types as $type ) {
    $opt_types[$type['id']] = $type['type'].' - '.$type['desc'];
}

$groups = $ci->db->from('sip_voucher_group')
    ->select('id, group, desc')
    ->get()
    ->result_array();
$opt_group = array();
foreach( $groups as $group ) {
    $opt_group[$group['id']] = $group['group'].' - '.$group['desc'];
}

$status_valid = array(
    'name'          => 'voucher_status',
    'value'         => 1,
    'checked'       => TRUE,
);
$status_invalid = array(
    'name'          => 'voucher_status',
    'value'         => 0,
    'checked'       => FALSE,
);

$extra = array(
    'class' => 'form-control select2'
);

?>

	<div class="form-group">
		<label>Type:</label><br/>
		<?php echo form_dropdown('voucher_type', $opt_types, null, $extra); ?>
		<div class="help-block"><em class="note ">type of voucher</em></div>
	</div>

	<div class="form-group">
		<label>Group:</label><br/>
		<?php echo form_dropdown('voucher_group', $opt_group, null, $extra); ?>
		<div class="help-block"><em class="note ">group of voucher</em></div>
	</div>

    <div class="form-group">
        <label>Status:</label>
        <div class="radio">
            <label>
                <?php echo form_radio($status_valid); ?> Valid
            </label>
        </div>
        <div class="radio">
            <label>
                <?php echo form_radio($status_invalid); ?> Not Valid
            </label>
        </div>
        <div class="help-block"><em class="note ">status of voucher</em></div>
    </div>


</form>
Are you sure want to import/update selected vouchers ?
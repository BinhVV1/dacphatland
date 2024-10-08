<?php
if(!defined('ABSPATH')) {
    die();
}
?>
<div class="wpallexport-collapsed wpallexport-section">
	<div class="wpallexport-content-section" style="margin-top:10px;">
		<div class="wpallexport-collapsed-header" style="padding-left: 25px;">
			<h3><?php esc_html_e('Configure Advanced Settings','wp_all_export_plugin');?></h3>
		</div>
		<div class="wpallexport-collapsed-content" style="padding: 0;">
			<div class="wpallexport-collapsed-content-inner">				
				<table class="form-table" style="max-width:none;">
					<tr>
						<td colspan="3">

							<div class="input" style="margin:5px 0px;">
								<label for="records_per_request"><?php esc_html_e('In each iteration, process', 'wp_all_export_plugin');?> <input type="text" name="records_per_iteration" class="wp_all_export_sub_input" style="width: 40px;" value="<?php echo esc_attr($post['records_per_iteration']) ?>" /> <?php esc_html_e('records', 'wp_all_export_plugin'); ?></label>
								<a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('WP All Export must be able to process this many records in less than your server\'s timeout settings. If your export fails before completion, to troubleshoot you should lower this number.', 'wp_all_export_plugin'); ?>">?</a>
							</div>

                            <?php

                            if(empty($post['cpt'])) {
	                            $postTypes           = [];
	                            $exportqueryPostType = [];

	                            if ( isset( $post['exportquery'] ) && ! empty( $post['exportquery']->query['post_type'] ) ) {
		                            $exportqueryPostType = [ $post['exportquery']->query['post_type'] ];
	                            }

	                            if ( empty( $postTypes ) ) {
		                            $postTypes = $exportqueryPostType;
	                            }

                                $post['cpt'] = $postTypes;
                            }

                            $cpt_initial = $post['cpt'];
                            $cpt_name = is_array($post['cpt']) ? reset($post['cpt']) : $post['cpt'];

                            if ( $cpt_name !== 'taxonomies' ) {

	                            if ( $cpt_name === 'users' ) {
		                            $cpt_name = 'user';
	                            }

	                            $display_verb     = 'created';
	                            $display_cpt_name = $cpt_name;
	                            $tooltip_cpt_name = strtolower( wp_all_export_get_cpt_name( $cpt_initial ) );

	                            if ( $display_cpt_name === 'shop_order' ) {
		                            $display_cpt_name = 'WooCommerce Order';
		                            $display_verb     = 'completed';
	                            }

	                            if ( $display_cpt_name === 'shop_customer' ) {
		                            $display_cpt_name = 'WooCommerce Customer';
		                            $display_verb     = 'created';
	                            }

	                            if ( $display_cpt_name === 'custom_wpae-gf-addon' ) {
		                            $display_cpt_name = 'Gravity Forms Entry';
	                            }

	                            if ( $display_cpt_name === 'comments' ) {
		                            $display_cpt_name = 'comment';
	                            }
                            }


                            ?>
                            <div class="input">

                                <input type="hidden" id="wpae-post-name" value="<?php echo $display_cpt_name; ?>" />
                                <input type="hidden" name="enable_real_time_exports" value="0"/>
                                <input type="checkbox"
                                       id="enable_real_time_exports" <?php if ((isset($post['xml_template_type']) && $post['xml_template_type'] == XmlExportEngine::EXPORT_TYPE_GOOLE_MERCHANTS) || $cpt_name === 'shop_customer') { ?> disabled="disabled" <?php } ?>
                                       name="enable_real_time_exports"
                                       value="1"  />
                                <label for="enable_real_time_exports"><?php esc_html_e('Export each ' . esc_html($display_cpt_name) . ' in real time as they are ' . esc_html($display_verb), 'wp_all_export_plugin') ?></label>
                                <span>
                                            <a href="#help" class="wpallexport-help" style="position: relative; top: -2px;"
                                                <?php
                                                if (isset($post['xml_template_type']) && $post['xml_template_type'] == XmlExportEngine::EXPORT_TYPE_GOOLE_MERCHANTS) { ?>
                                                    title="<?php esc_html_e('This feature it not available for Google Merchants Exports.', 'wp_all_export_plugin'); ?>"
                                                <?php } else if ($cpt_name === 'shop_customer')
                                                {
                                                    ?>

                                                    title="<?php esc_html_e('This feature it not available for Customer Exports.', 'wp_all_export_plugin'); ?>"
                                                <?php } else { ?>
                                               title="<?php esc_html_e('This will export ' . esc_html(strtolower($tooltip_cpt_name)) . ' one by one, in real time, as they are ' . esc_html($display_verb) . '.'); ?> <br/><br/><strong>Upgrade to the Pro edition of WP All Export to use this option.</strong>">
							                <?php } ?>>?</a>
                                </span>

                                <div class="wpallexport-free-edition-notice php-rte-upgrade" style="margin: 15px 0; padding: 20px; width: 600px; display: none;">
                                    <a class="upgrade_link" target="_blank" href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=5839967&edd_options%5Bprice_id%5D=1&utm_source=export-plugin-free&utm_medium=upgrade-notice&utm_campaign=real-time-exports"><?php esc_html_e('Upgrade to the Pro edition of WP All Export to export each '. $display_cpt_name .' in real time.','wp_all_export_plugin');?></a>
                                    <p><?php esc_html_e('If you already own it, remove the free edition and install the Pro edition.', 'wp_all_export_plugin'); ?></p>
                                </div>
                            </div>



                            <div class="input" style="margin:5px 0px;">
								<input type="hidden" name="export_only_new_stuff" value="0" />
								<input type="checkbox" id="export_only_new_stuff" name="export_only_new_stuff" value="1" />
								<label for="export_only_new_stuff"><?php printf(esc_html__('Only export %s once', 'wp_all_export_plugin'), empty($post['cpt']) ? __('records', 'wp_all_export_plugin') : esc_html(wp_all_export_get_cpt_name($post['cpt']))); ?></label>
								<a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('If re-run, this export will only include records that have not been previously exported.<br><br><strong>Upgrade to the Pro edition of WP All Export to use this option.</strong>', 'wp_all_export_plugin'); ?>">?</a>

                                <div class="wpallexport-free-edition-notice only-export-posts-once" style="margin: 15px 0; padding: 20px; width: 600px; display: none;">
                                    <a class="upgrade_link" target="_blank"
                                       href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=5839967&edd_options%5Bprice_id%5D=1&utm_source=export-plugin-free&utm_medium=upgrade-notice&utm_campaign=export-only-new-stuff">
                                        <?php $noun = empty($post['cpt']) ? __('records', 'wp_all_export_plugin') : esc_html(wp_all_export_get_cpt_name($post['cpt'])); ?>
                                        <?php esc_html_e('Upgrade to the Pro edition of WP All Export to only export '.  $noun .' once.','wp_all_export_plugin');?></a>
                                    <p><?php esc_html_e('If you already own it, remove the free edition and install the Pro edition.', 'wp_all_export_plugin'); ?></p>
                                </div>
                            </div>
							<div class="input" style="margin:5px 0px;">
								<input type="hidden" name="export_only_modified_stuff" value="0" />
								<input type="checkbox" id="export_only_modified_stuff" name="export_only_modified_stuff" value="1" <?php echo $post['export_only_modified_stuff'] ? 'checked="checked"': '' ?> <?php if (is_array($post['cpt']) && $post['cpt'][0] === 'users') {?> disabled="disabled" <?php }?> />
								<label for="export_only_modified_stuff" disabled="disabled"><?php printf(esc_html__('Only export %s that have been modified since last export', 'wp_all_export_plugin'), empty($post['cpt']) ? __('records', 'wp_all_export_plugin') : esc_html(wp_all_export_get_cpt_name($post['cpt'], 2, $post))); ?></label>

                                <?php
                                if(is_array($post['cpt']) && $post['cpt'][0] === 'users') {
                                    ?>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('This feature is not available for user exports.', 'wp_all_export_plugin'); ?>">?</a>

                                    <?php
                                } else {
                                ?>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('If re-run, this export will only include records that have been modified since last export run.<br><br><strong>Upgrade to the Pro edition of WP All Export to use this option.</strong>', 'wp_all_export_plugin'); ?>">?</a>
                                <?php
                                }
                                ?>
                                <div class="wpallexport-free-edition-notice only-export-modified-posts" style="margin: 15px 0; padding: 20px; width: 600px; display: none;">
                                    <a class="upgrade_link" target="_blank"
                                       href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=5839967&edd_options%5Bprice_id%5D=1&utm_source=export-plugin-free&utm_medium=upgrade-notice&utm_campaign=export-only-modified-stuff">
                                        <?php $noun = empty($post['cpt']) ? __('records', 'wp_all_export_plugin') : esc_html(wp_all_export_get_cpt_name($post['cpt'])); ?>
                                        <?php esc_html_e('Upgrade to the Pro edition of WP All Export to only export '.  $noun .' that have been modified since last export.','wp_all_export_plugin');?></a>
                                    <p><?php esc_html_e('If you already own it, remove the free edition and install the Pro edition.', 'wp_all_export_plugin'); ?></p>
                                </div>

                            </div>

							<div class="input" style="margin:5px 0px;">
								<input type="hidden" name="include_bom" value="0" />
								<input type="checkbox" id="include_bom" name="include_bom" value="1" <?php echo $post['include_bom'] ? 'checked="checked"': '' ?> />
								<label for="include_bom"><?php esc_html_e('Include BOM to enable non-ASCII characters in Excel', 'wp_all_export_plugin') ?></label>
								<a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('The BOM will help some programs like Microsoft Excel read your export file if it contains non-ASCII characters. These can include curly quotation marks or non-English characters such as umlauts.', 'wp_all_export_plugin'); ?>">?</a>
							</div>
							<div class="input" style="margin:5px 0px;">
								<input type="hidden" name="creata_a_new_export_file" value="0" />
								<input type="checkbox" id="creata_a_new_export_file" name="creata_a_new_export_file" value="1" <?php echo $post['creata_a_new_export_file'] ? 'checked="checked"': '' ?> />
								<label for="creata_a_new_export_file"><?php esc_html_e('Create a new file each time export is run', 'wp_all_export_plugin') ?></label>
								<a href="#help" class="wpallexport-help" style="position: relative; top: -2px;" title="<?php esc_html_e('If disabled, the export file will be overwritten every time this export run.', 'wp_all_export_plugin'); ?>">?</a>
							</div>							
							<div class="input" style="margin:5px 0px;">
								<input type="hidden" name="split_large_exports" value="0" />
								<input type="checkbox" id="split_large_exports" name="split_large_exports" class="switcher" value="1" <?php echo $post['split_large_exports'] ? 'checked="checked"': '' ?> />
								<label for="split_large_exports"><?php esc_html_e('Split large exports into multiple files', 'wp_all_export_plugin') ?></label>
								<span class="switcher-target-split_large_exports pl17" style="display:block; clear: both; width: 100%;">
									<div class="input pl17" style="margin:5px 0px;">							
										<label for="records_per_request"><?php esc_html_e('Limit export to', 'wp_all_export_plugin');?></label> <input type="text" name="split_large_exports_count" class="wp_all_export_sub_input" style="width: 50px;" value="<?php echo esc_attr($post['split_large_exports_count']) ?>" /> <?php esc_html_e('records per file', 'wp_all_export_plugin'); ?>
									</div>																				
								</span>			
							</div>
                            <div class="input" style="margin:5px 0px;">
                                <input type="hidden" name="allow_client_mode" value="0"/>
                                <input type="checkbox" id="allow_client_mode" name="allow_client_mode"
                                       value="1" />
                                <label for="allow_client_mode"><?php esc_html_e('Allow non-admins to run this export in Client Mode', 'wp_all_export_plugin') ?></label>
                                <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;" title="<?php esc_html_e('When enabled, users with access to Client Mode will be able to run this export and download the export file. Go to All Export > Settings to give users access to Client Mode. <br><br><strong>Upgrade to the Pro edition of WP All Export to use this option.</strong>'); ?>">?</a>
							    </span>

                                <div class="wpallexport-free-edition-notice client-mode-notice" style="margin: 15px 0; padding: 20px; width: 600px; display: none;">
                                    <a class="upgrade_link" target="_blank"
                                       href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=5839967&edd_options%5Bprice_id%5D=1&utm_source=export-plugin-free&utm_medium=upgrade-notice&utm_campaign=client-mode">
                                        <?php $noun = empty($post['cpt']) ? __('records', 'wp_all_export_plugin') : esc_html(wp_all_export_get_cpt_name($post['cpt'])); ?>
                                        <?php esc_html_e('Upgrade to the Pro edition of WP All Export to allow non-admins to run this export in Client Mode.','wp_all_export_plugin');?></a>
                                    <p><?php esc_html_e('If you already own it, remove the free edition and install the Pro edition.', 'wp_all_export_plugin'); ?></p>
                                </div>
                            </div>
							<br>
							<hr>
							<p style="text-align:right;">
								<div class="input">
									<label for="save_import_as" style="width: 103px;"><?php esc_html_e('Export Name:','wp_all_export_plugin');?></label>
									<input type="text" name="friendly_name" title="<?php esc_html_e('Save Export Name...', 'pmxi_plugin') ?>" style="vertical-align:middle; background:#fff !important; width: 350px;" value="<?php echo wp_all_export_clear_xss(esc_attr($post['friendly_name'])); ?>"  />
								</div>
							</p>
						</td>
					</tr>											
				</table>
			</div>
		</div>
	</div>
</div>	
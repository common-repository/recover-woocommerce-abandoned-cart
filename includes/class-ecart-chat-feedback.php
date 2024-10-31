<?php
if (!class_exists('Ecart_Uninstall_Feedback')) :

    /**
     * Class for catch Feedback on uninstall
     */
    class Ecart_Uninstall_Feedback {

        public function __construct() {
            add_action('admin_footer', array($this, 'deactivate_scripts'));
            add_action('wp_ajax_ecart_submit_uninstall_reason', array($this, "send_uninstall_reason"));
        }

        private function get_uninstall_reasons() {

            $reasons = array(
                array(
                    'id' => 'could-not-understand',
                    'text' => __('I couldn\'t understand how to make it work', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => __('Would you like us to assist you?', 'recover-woocommerce-abandoned-cart')
                ),
                array(
                    'id' => 'found-better-plugin',
                    'text' => __('I found a better plugin', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'text',
                    'placeholder' => __('Which plugin?', 'recover-woocommerce-abandoned-cart')
                ),
                array(
                    'id' => 'not-have-that-feature',
                    'text' => __('The plugin is great, but I need specific feature that you don\'t support', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => __('Could you tell us more about that feature?', 'recover-woocommerce-abandoned-cart')
                ),
                array(
                    'id' => 'is-not-working',
                    'text' => __('The plugin is not working', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => __('Could you tell us a bit more whats not working?', 'recover-woocommerce-abandoned-cart')
                ),
                array(
                    'id' => 'looking-for-other',
                    'text' => __('It\'s not what I was looking for', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => 'Could you tell us a bit more?'
                ),
                array(
                    'id' => 'did-not-work-as-expected',
                    'text' => __('The plugin didn\'t work as expected', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => __('What did you expect?', 'recover-woocommerce-abandoned-cart')
                ),
                array(
                    'id' => 'other',
                    'text' => __('Other', 'recover-woocommerce-abandoned-cart'),
                    'type' => 'textarea',
                    'placeholder' => __('Could you tell us a bit more?', 'recover-woocommerce-abandoned-cart')
                ),
            );

            return $reasons;
        }

        public function deactivate_scripts() {

            global $pagenow;
            if ('plugins.php' != $pagenow) {
                return;
            }
            $reasons = $this->get_uninstall_reasons();
            ?>
            <div class="ecart-modal" id="ecart-ecart-modal">
                <div class="ecart-modal-wrap">
                    <div class="ecart-modal-header">
                        <h3><?php _e('If you have a moment, please let us know why you are deactivating:', 'recover-woocommerce-abandoned-cart'); ?></h3>
                    </div>
                    <div class="ecart-modal-body">
                        <ul class="reasons">
                            <?php foreach ($reasons as $reason) { ?>
                                <li data-type="<?php echo esc_attr($reason['type']); ?>" data-placeholder="<?php echo esc_attr($reason['placeholder']); ?>">
                                    <label><input type="radio" name="selected-reason" value="<?php echo $reason['id']; ?>"> <?php echo $reason['text']; ?></label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="ecart-modal-footer">
                        <a href="#" class="dont-bother-me"><?php _e('I rather wouldn\'t say', 'recover-woocommerce-abandoned-cart'); ?></a>
                        <button class="button-primary ecart-model-submit"><?php _e('Submit & Deactivate', 'recover-woocommerce-abandoned-cart'); ?></button>
                        <button class="button-secondary ecart-model-cancel"><?php _e('Cancel', 'recover-woocommerce-abandoned-cart'); ?></button>
                    </div>
                </div>
            </div>

            <style type="text/css">
                .ecart-modal {
                    position: fixed;
                    z-index: 99999;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    background: rgba(0,0,0,0.5);
                    display: none;
                }
                .ecart-modal.modal-active {display: block;}
                .ecart-modal-wrap {
                    width: 50%;
                    position: relative;
                    margin: 10% auto;
                    background: #fff;
                }
                .ecart-modal-header {
                    border-bottom: 1px solid #eee;
                    padding: 8px 20px;
                }
                .ecart-modal-header h3 {
                    line-height: 150%;
                    margin: 0;
                }
                .ecart-modal-body {padding: 5px 20px 20px 20px;}
                .ecart-modal-body .input-text,.ecart-modal-body textarea {width:75%;}
                .ecart-modal-body .reason-input {
                    margin-top: 5px;
                    margin-left: 20px;
                }
                .ecart-modal-footer {
                    border-top: 1px solid #eee;
                    padding: 12px 20px;
                    text-align: right;
                }
            </style>
            <script type="text/javascript">
                (function ($) {
                    $(function () {
                        var modal = $('#ecart-ecart-modal');
                        var deactivateLink = '';
                        $('#the-list').on('click', 'a.ecart-deactivate-link', function (e) {
                            e.preventDefault();
                            modal.addClass('modal-active');
                            deactivateLink = $(this).attr('href');
                            modal.find('a.dont-bother-me').attr('href', deactivateLink).css('float', 'left');
                        });
                        modal.on('click', 'button.ecart-model-cancel', function (e) {
                            e.preventDefault();
                            modal.removeClass('modal-active');
                        });
                        modal.on('click', 'input[type="radio"]', function () {
                            var parent = $(this).parents('li:first');
                            modal.find('.reason-input').remove();
                            var inputType = parent.data('type'),
                                    inputPlaceholder = parent.data('placeholder'),
                                    reasonInputHtml = '<div class="reason-input">' + (('text' === inputType) ? '<input type="text" class="input-text" size="40" />' : '<textarea rows="5" cols="45"></textarea>') + '</div>';

                            if (inputType !== '') {
                                parent.append($(reasonInputHtml));
                                parent.find('input, textarea').attr('placeholder', inputPlaceholder).focus();
                            }
                        });

                        modal.on('click', 'button.ecart-model-submit', function (e) {
                            e.preventDefault();
                            var button = $(this);
                            if (button.hasClass('disabled')) {
                                return;
                            }
                            var $radio = $('input[type="radio"]:checked', modal);
                            var $selected_reason = $radio.parents('li:first'),
                                    $input = $selected_reason.find('textarea, input[type="text"]');

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'ecart_submit_uninstall_reason',
                                    reason_id: (0 === $radio.length) ? 'none' : $radio.val(),
                                    reason_info: (0 !== $input.length) ? $input.val().trim() : ''
                                },
                                beforeSend: function () {
                                    button.addClass('disabled');
                                    button.text('Processing...');
                                },
                                complete: function () {
                                    window.location.href = deactivateLink;
                                }
                            });
                        });
                    });
                }(jQuery));
            </script>
            <?php
        }

        public function send_uninstall_reason() {

            global $wpdb;

            $current_user = wp_get_current_user();
            $user_name = ( $current_user->exists() ) ? $current_user->user_login : '';
            $user_email = ( $current_user->exists() ) ? $current_user->user_email : '';

            if (!isset($_POST['reason_id'])) {
                wp_send_json_error();
            }

            $data = array(
                "domain" => get_site_url(),
                'reason_id' => sanitize_text_field($_POST['reason_id']),
                'reason_info' => isset($_REQUEST['reason_info']) ? trim(stripslashes($_REQUEST['reason_info'])) : '',
                'ecart_version' => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION,
                'user_email' => $user_email
            );

            $data['details'] = array(
                'software' => $_SERVER['SERVER_SOFTWARE'],
                'php_version' => phpversion(),
                'mysql_version' => $wpdb->db_version(),
                'wp_version' => get_bloginfo('version'),
                'wc_version' => (!defined('WC_VERSION')) ? '' : WC_VERSION,
                'locale' => get_locale(),
                'multisite' => is_multisite() ? 'Yes' : 'No',
                'date' => gmdate("M d, Y h:i:s A"),
                'user_name' => $user_name
            );

            $shop_token = get_option('abcart_shop_token');
            $shop_id = get_option('abcart_shop_id');

            $feedback_args = apply_filters('register_saas_args', array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => false,
                'headers' => array(
                    "Content-Type" => "application/json",
                    "Shop-ID" => $shop_id,
                    "Plugin-Token" => $shop_token,
                    "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                ),
                'body' => json_encode($data)
                )
            );

            // Write an action/hook here in ecartchat to recieve the data
            $resp = wp_remote_post(ABCART_API_ENDPOINT_BASE_V1 . '/shops/deactivate', $feedback_args);

            wp_send_json_success();
        }

    }

    new Ecart_Uninstall_Feedback();

endif;
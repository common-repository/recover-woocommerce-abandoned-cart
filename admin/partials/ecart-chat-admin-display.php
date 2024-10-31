<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<script type="text/javascript">
    jQuery(window).on('load',function(){
        jQuery('#myModal').modal('show');
    });
</script>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
        <div id="popup" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-text-center uk-margin-auto-vertical">
            <h4 class="uk-text-emphasis uk-text-bold">Welcome to ecart.chat</h4>
            <p>Please click on connect button to activate<br>#1 messenger marketing solution for eCommerce.</p>
            <div class="uk-card uk-card-default uk-card-body uk-width-3-4 uk-container">
                <div class="uk-flex uk-flex-around uk-flex-middle ">
                    <img src="<?php echo ABCART_PLUGIN_BASE_URL; ?>admin/images/ecart-chat-logo.png" alt="logo">
                    <img src="<?php echo ABCART_PLUGIN_BASE_URL; ?>admin/images/plus-grey.png" alt="logo">
                    <img src="<?php echo ABCART_PLUGIN_BASE_URL; ?>admin/images/woocommerce-logo.png" alt="logo">
                </div>
            </div>
            <p>Connect your store with EcartChat to take<br>accelerate your business growth</p>
            <a id="letsconnect" class="ecart-letsconnect uk-button uk-button-primary uk-button-large uk-text-capitalize" href="javascript:void(0)">Let's Connect</a>
        </div>
    </div>
      </div>
    </div>

  </div>
</div>

<?php
    defined( 'ABSPATH' ) || exit;

?>
<div class="rc-connect-robin">
    <div class="title-wrapper">
      <h3><?php echo ! empty($connected) ? __('Boost your sales and conversion with chat communication', 'robin-chat') :  __('Connect Robin to WordPress', 'robin-chat'); ?></h3>
      <p><?php echo ! empty($connected) ? __('Start converting site visitors into customers and subscribers', 'robin-chat') : __('This page will help you to connect your wordpress site with Robin in few steps', 'robin-chat'); ?></p>
    </div>
    <div class="featured-image">
      <img src="<?php echo ROBIN_CHAT_ASSETS_URL. '/images/robin-connect-to-wordpress.png'; ?>" alt="" />
    </div>
    <hr />
    <div class="content">
        <?php
            If(empty($connected)) {
        ?>
        <h4><?php echo __('Let\'s get started!', 'robin-chat'); ?></h4>
        <ol>
          <li><?php echo sprintf('%s %s %s  with Robin', '<a href="#">', __('Sign in / Create an account', 'robin-chat'), '</a>'); ?></li>
          <li><?php echo sprintf('Navigate to your %s %s %s  page', '<a href="#">', __('account settings', 'robin-chat'), '</a>'); ?></li>
          <li><?php echo __('Copy the  API Keys and paste your below', 'robin-chat'); ?></li>
        </ol>
        <?php
            }
        ?>
      <form action="" method="post" class="robin-chat-form <?php echo !empty($connection_error_message) ? ' connection-error' : ''; ?> " name="robin-chat-account-api-key-form">
          <?php
              if(!empty($connected)) {
          ?>
          <div class="rc-account-form-connected">
            <h3><?php echo __('Your account is connected!', 'robin-chat'); ?></h3>
            <p>
              <?php echo __('Your Wordpress website is linked to the Robin app. For a more extensive explanation, visit the robin dashboard or see the overall summary right here on the wordpress dashboard.', 'robin-chat'); ?>
            </p>
            <a href="<?php echo ROBIN_CHAT_SETTINGS_DASHBOARD_PAGE; ?>" class="rc-form-button" title="<?php __('Continue to dashboard', 'robin-chat'); ?>"><?php echo __('Continue to dashboard', 'robin-chat'); ?></a>
          </div>
          <?php
              } else if(!empty($connection_error_message)) {
          ?>
              <div class="rc-account-form-connection-error">
                <h3><?php echo esc_attr(__('Credential in use', 'robin-chat')); ?></h3>
                <p>
                    <?php echo  __('Another website is already connected using these credentials. Please reconnect or <strong>create a new app</strong> in your Robin dashboard', 'robin-chat'); ?>
                </p>
                <a href="<?php echo ROBIN_CHAT_SETTINGS_DASHBOARD_PAGE; ?>" class="rc-form-button" title="<?php __('Connect to Robin', 'robin-chat'); ?>"><?php echo __('Connect to Robin', 'robin-chat'); ?></a>
              </div>
          <?php } else { ?>
          <div class="rc-form-group">
            <label for="robin-chat-account-api-key"><?php echo __('API Key:', 'robin-app'); ?></label>
            <input type="text" name="robin-chat-account-api-key" value="<?php echo isset($_POST['robin-chat-account-api-key']) ? $_POST['robin-chat-account-api-key'] : '' ?>" placeholder="<?php echo __('Paste your key here', 'robin-chat'); ?>" required/>
            <?php wp_nonce_field('robin-chat-account-api-key', 'robin-chat-account-api-key-nonce'); ?>
          </div>
          <div class="rc-form-submit">
            <button type="submit" name="account-api-key-submit" class="rc-form-button"><?php echo __('Authorize', 'robin-chat'); ?></button>
          </div>
          <?php } ?>
      </form>
      <?php
          if(empty($connected)) {
      ?>
      <div class="rc-footnote">
        <p><?php echo sprintf('Get help if you have any problems, questions, connecting to your site or just want to thank us for for the good service by sending an email to %s sales@robinapp.co %s', '<a href="mailto: sales@robinapp.co">', '</a>'); ?></p>
      </div>
      <?php } ?>
    </div>
    
</div>
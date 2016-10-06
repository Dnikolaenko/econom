<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
    <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
    <div style="margin-bottom: 25px;">
    <script type="text/javascript"><!--
          var dataFromClients = new Array(
                                    '<?php echo ($name == $entry_name ? '' : $name); ?>',
                                    '<?php echo ($email == $entry_email ? '' : $email); ?>',
                                    //'<?php echo ($text == $entry_text ? '' : $text); ?>',
                                    ''
                                  );
          var startValueInput = new Array();
          var startText = new Array(
                            '<?php echo $entry_name; ?>',
                            '<?php echo $entry_email; ?>',
                            //'<?php echo $entry_text; ?>',
                            '<?php echo $entry_captcha; ?>'
                          );

        //--></script>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
    <form method="post" action="index.php?route=information/question" id='question'>
    <table class="form" style="width: 100%">
      <tr>
        <?php /*
        <td style="padding: 15px 0;">
          <div class="input">
            <div class="left"></div>
              <select name="type">
                <option value="ask" <?php echo ($type == 'ask' ? 'selected' : ''); ?>><?php echo $entry_to_manager; ?></option>
                <option value="claim" <?php echo ($type == 'claim' ? 'selected' : ''); ?>><?php echo $entry_to_director; ?></option>
              </select>
            <div class="right"></div>
          </div>
        </td><td></td>
         */ ?>
        <td><input type="radio" name="type" value="ask" <?php echo ($type == 'ask' ? 'checked' : ''); ?> /> <?php echo $entry_to_manager; ?><br />
            <input type="radio" name="type" value="claim" <?php echo ($type == 'claim' ? 'checked' : ''); ?> /> <?php echo $entry_to_director; ?>
        </td>
      </tr>
      <tr>
        <td>
          <span class="error">&nbsp;<?php if ($error_name) { ?><?php echo $error_name; ?><?php } ?></span>
          <div class="input zirka">
            <div class="left"></div><input type="text" value="<?php echo $name; ?>" name="name" title="<?php echo $entry_name; ?>"/><div class="right"></div>
          </div>
        </td>
        <td>
          <span class="error">&nbsp;<?php if ($error_email) { ?><?php echo $error_email; ?><?php } ?></span>
          <div class="input zirka">
            <div class="left"></div><input type="text" value="<?php echo $email; ?>" name="email" title="<?php echo $entry_email; ?>"/><div class="right"></div>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding:15px 0;">
          <?php if ($error_text) { ?>
          <span class="error"><?php echo $error_text; ?></span>
          <?php } ?>
          <div class="textarea">
            <div class="left"></div><textarea rows="5" cols="50" type="text" name="text" title="<?php echo $entry_text; ?>"><?php echo $text; ?></textarea><div class="right"></div>
          </div>
        </td>
      </tr>
      <tr>
        <td width="50%" align="center">
          <img src="index.php?route=information/question/captcha" id="captcha" />
        </td>
        <td width="50%">
          <?php if ($error_captcha) { ?>
          <span class="error"><?php echo $error_captcha; ?></span>
          <?php } ?>
          <div class="input zirka">
            <div class="left"></div><input type="text" value="<?php echo $entry_captcha; ?>" name="captcha" title="<?php echo $entry_captcha; ?>" /><div class="right"></div>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="right">
          <a onclick="$('#question').submit();" class="button"><span><?php echo $button_send_question; ?></span></a>
        </td>
      </tr>
    </table>
    </form>
<script type="text/javascript"><!--
  $('#question input[type=text]').each(
      function(){
          var position = $('#question input[type=text]').index(this);
          //alert(position);
          if (!dataFromClients[position]) {
            startValueInput.push(this.value);
          }
          else {
            startValueInput.push(this.value);
            $(this).addClass('active');
          }

          if (dataFromClients[position]) $(this).attr('value', dataFromClients[position]);
      }
    );
	$('#question input[type=text]').focus(
	    function(){
			var position = $('#question input[type=text]').index(this);
			//if (startValueInput[position] == $.trim($(this).attr('value'))) {
            if (startValueInput[position] == startText[position]) {
                if (!dataFromClients[position]) {
                  $(this).attr({value: ""}).toggleClass('active');
                }
			}
		}
	);
	$('#question input[type=text]').blur(
	    function(){
			var position = $('#question input[type=text]').index(this);

            if ($.trim($(this).attr('value')) == '') {
				$(this).attr({value: startValueInput[position]}).toggleClass('active');
			}
            if ($.trim($(this).attr('value')) != startText[position])
              dataFromClients[position] = $.trim($(this).attr('value'));
		}
	);
//--></script>
    </div>
    <table>
      <?php foreach ($questions as $question) { ?>
        <tr><td class="description">
          <?php echo html_entity_decode($question['text'], ENT_QUOTES, 'UTF-8'); ?>
          <?php echo html_entity_decode($question['answer'], ENT_QUOTES, 'UTF-8'); ?><br />
        </td></tr>
      <?php } ?>
    </table>

    </div>
  </div>
</div>
<?php echo $footer; ?> 
<?php

// Get the current page url
$current_url_form_page = home_url($wp->request);


// Set default for form fields
$menu_name = '';
$position = '';
$visible = '';

// Form processing
if (is_post_request()) {

  // Handle form values sent by new.php

  $menu_name = $_POST['menu_name'] ?? '';
  $position = $_POST['position'] ?? '';
  $visible = $_POST['visible'] ?? '';

  echo "Form parameters<br />";
  echo "Menu name: " . $menu_name . "<br />";
  echo "Position: " . $position . "<br />";
  echo "Visible: " . $visible . "<br />";
}

?>

<div id="content">
  <div class="page new">
    <h1>Single Page Form Processing</h1>

    <form action="<?php echo $current_url_form_page; ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($menu_name); ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <option value="1" <?php if ($position == "1") {
                                echo " selected";
                              } ?>>1</option>
            <option value="2" <?php if ($position == "2") {
                                echo " selected";
                              } ?>>2</option>
            <option value="3" <?php if ($position == "3") {
                                echo " selected";
                              } ?>>3</option>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php if ($visible == "1") {
                                                            echo " checked";
                                                          } ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Submit" />
      </div>
    </form>

  </div>

</div>
<?php
function gt_asides_deactivate() {
  // flush the rewrite rules (like flush the cache in drupal? Necessary every time there are changes in the database)
  flush_rewrite_rules();
}
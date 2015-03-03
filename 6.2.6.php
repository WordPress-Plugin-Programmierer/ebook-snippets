<a href="#" title="<?php esc_attr_e( 'Butter & Toast', 'mm_trans' ); ?>">Butter & Toas</a>
<?php // ist das selbe wie ?>
<a href="#" title="<?php echo esc_attr__( 'Butter & Toast', 'mm_trans' ); ?>">Butter & Toas</a>
<?php // und gibt <a href="#" title="Butter &amp; Toast">Butter & Toast</a> aus. ?>

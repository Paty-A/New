<form role='search' method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
	<label class="screen-reader-text" for="s">Search for:</label>
	<input type="text" class="search_input" value="To search, type and hit enter" name="s" id="s" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}" />
	<input type="hidden" id="searchsubmit" value="Search" />
</form>

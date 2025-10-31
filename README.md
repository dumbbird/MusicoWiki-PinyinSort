# PinyinSort - Musico.wiki Customized Edition
Add pinyin as a category sorting collation - https://musico.wiki

## Install
* Clone the respository, rename it to PinyinSort and copy to extensions folder
* Add `wfLoadExtension('PinyinSort')`; to your LocalSettings.php
* Add `$wgCategoryCollation = 'pinyin';` to your LocalSettings.php to activate PinyinSort
	* You need to run `updateCollation.php` as an post-requisite for changing collation.
* You are done!

## Configuration
* Alternatively, you can use `$wgCategoryCollation = 'pinyin-noprefix';` to automatically strip prefixes.
	* For example, "Subproject:PageA" will be transformed to "PageA" during collation process.
	* You need to run `updateCollation.php` as an post-requisite for changing collation.

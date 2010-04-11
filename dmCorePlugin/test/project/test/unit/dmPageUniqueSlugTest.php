<?php

require_once(realpath(dirname(__FILE__).'/../../..').'/unit/helper/dmModuleUnitTestHelper.php');
$helper = new dmModuleUnitTestHelper();
$helper->boot();

$t = new lime_test();

$table = dmDb::table('DmPage');

$page1 = $table->create(array(
  'name' => 'name1',
  'slug' => 'slug1',
  'module' => 'test',
  'action' => 'test1'
))->saveGet();

$t->ok($page1->exists(), 'Created a page');

$t->is('slug1', $page1->slug, 'Page slug is slug1');

$t->comment('Saving page with existing slug');

$page2 = $table->create(array(
  'name' => 'name2',
  'slug' => 'slug1',
  'module' => 'test',
  'action' => 'test2'
))->saveGet();

$t->ok($page2->exists(), 'Created a page');

$t->is($page2->slug, 'slug1-1', 'Page2 slug is slug1-1');

$page1->slug = 'slug1-1';
$page1->save();

$t->is($page1->slug, 'slug1-2', 'Page1 slug is now slug1-2');

$page2->slug = 'slug1';
$page2->save();

$t->is($page2->slug, 'slug1', 'Page2 slug is now slug1');

$page2->slug = '';
$page2->save();

$t->is($page2->slug, '-1', 'Page2 slug is now -1');

//$helper->get('page_tree_watcher')->connect();
//
//$domain1 = dmDb::table('DmTestDomain')->create(array(
//  'title' => '---'
//))->saveGet();
//
//$domain2 = dmDb::table('DmTestDomain')->create(array(
//  'title' => '---'
//))->saveGet();
//
//$t->is($domain1->getDmPage()->slug, 'dm-test-domains-1');
//$t->is($domain2->getDmPage()->slug, 'dm-test-domains-2');
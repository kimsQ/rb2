/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2 서비스워커(serviceWorker)
 * 캐싱스토리지
 * Licensed under an Apache-2 license.
 * Copyright 2018 redblock inc
 * --------------------------------------------------------------------------
 */

importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

if (workbox) {
 console.log(`Workbox가 로드 되었습니다.`);
} else {
 console.log(`Workbox가 로드되지 못했습니다.`);
}

// 프리캐싱
workbox.precaching.precacheAndRoute([

  {url: '/_core/css/sys.css', revision: '2.4.0'},
  {url: '/_core/js/sys.js', revision: '2.4.0'},

  {url: '/modules/comment/lib/Rb.comment.js', revision: '1.1'},

  '/plugins/font-awesome/4.7.0/css/font-awesome.css',
  '/plugins/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2?v=4.7.0',
  '/plugins/font-kimsq/1.0.0/css/font-kimsq.css',

  '/plugins/jquery/1.12.4/jquery.min.js',
  '/plugins/jquery/3.3.1/jquery.min.js',

  '/plugins/popper.js/1.14.0/umd/popper.min.js',
  '/plugins/bootstrap/4.4.1/css/bootstrap.min.css',
  '/plugins/bootstrap/4.4.1/js/bootstrap.min.js',

  '/plugins/rc/1.0.0/css/rc.css',
  '/plugins/rc/1.0.0/css/rc-add.css',
  '/plugins/rc/1.0.0/js/rc.js',
  '/plugins/rc/1.0.0/fonts/ratchicons.woff',

  '/plugins/is-loading/1.0.6/jquery.isloading.min.js',
  '/plugins/js-cookie/2.2.1/js.cookie.min.js',

  '/plugins/ckeditor5/16.0.0/classic/build/ckeditor.js',
  '/plugins/ckeditor5/16.0.0/classic/build/translations/ko.js',

  '/plugins/ckeditor5/16.0.0/decoupled-document/build/ckeditor.js',
  '/plugins/ckeditor5/16.0.0/decoupled-document/build/translations/ko.js',

  '/plugins/bootstrap-notify/3.1.3/bootstrap-notify.min.js',

  '/plugins/swiper/5.2.1/css/swiper.css',
  '/plugins/swiper/5.2.1/js/swiper.min.js',

  '/plugins/snap/1.9.3/rc-snap.js',

  '/plugins/jquery.countdown/2.2.0/jquery.countdown.min.js',
  '/plugins/jquery-form/4.2.2/jquery.form.min.js',

  '/plugins/autosize/3.0.14/autosize.min.js',
  '/plugins/clipboard/2.0.4/clipboard.min.js',
  '/plugins/markjs/8.11.1/jquery.mark.min.js',
  '/plugins/pulltorefresh/0.1.19/index.umd.min.js',

  '/plugins/photoswipe/4.1.2/photoswipe.css',
  '/plugins/photoswipe/4.1.2/default-skin/default-skin.css',
  '/plugins/photoswipe/4.1.2/photoswipe.min.js',
  '/plugins/photoswipe/4.1.2/photoswipe-ui-default.min.js',

  '/plugins/jquery-timeago/1.6.7/jquery.timeago.js',
  '/plugins/jquery-timeago/1.6.7/locales/jquery.timeago.ko.js',

  '/plugins/jQuery-Autocomplete/1.3.0/jquery.autocomplete.min.js',

]);

workbox.precaching.addRoute();

/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2 서비스워커(serviceWorker)
 * 백그라운드 알림 처리 - FCM (firebase cloud message)
 * Licensed under an Apache-2 license.
 * Copyright 2018 redblock inc
 * --------------------------------------------------------------------------
 */

importScripts('/_var/fcm.info.js');
importScripts(firebase_app_js_src);
importScripts(firebase_messaging_js_src);
importScripts('/_core/sw/fcm.js');

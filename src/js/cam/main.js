"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

window.doloresConfig = require("./config");

var analytics = require("../shared/analytics");
var explanation = require("../shared/explanation");
var facebook = require("../shared/facebook");
var forms = require("../shared/forms");
var google = require("../shared/google");
var hero = require("../shared/hero");
var interact = require("../shared/interact");
var menu = require("../shared/menu");
var pagination = require("../shared/pagination");
var twitter = require("../shared/twitter");

var Authenticator = require("../shared/components/Authenticator.react");
var Share = require("../shared/components/Share.react");
var StreamingLightbox = require("../shared/components/StreamingLightbox.react");

var map = require("./map");

$(function() {
  if ($("#authenticator").length) {
    React.render(<Authenticator />, $("#authenticator")[0]);
  }
  if ($("#share-container").length) {
    React.render(<Share />, $("#share-container")[0]);
  }
  if ($("#streaming-lightbox").length) {
    var title = $("#streaming-lightbox").attr("title");
    React.render(
        <StreamingLightbox title={title} />,
        $("#streaming-lightbox")[0]
    );
  }

  $(window).resize(menu.onResize);
  $(window).trigger("resize");

  analytics.setup();
  explanation.setup();
  facebook.setup();
  forms.setup();
  google.setup();
  hero.setup();
  interact.setup();
  map.setup();
  menu.setup();
  pagination.setup();
  twitter.setup();
});

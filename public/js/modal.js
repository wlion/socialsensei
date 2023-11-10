(function ($) {
  "use strict";

  $(window).on("load", function () {
    // Modal
    const $modal = $("#social-sensei-modal");

    if ($modal.length > 0) {
      const $modalClose = $modal.find("[data-modal-close]");

      $modalClose.each(() => {
        $(this).on("click", function () {
          $modal.toggleClass("modal--visible");
        });
      });
    }

    // Social Sensei
    const $generateSocial = $(
      "#wp-admin-bar-social-sensei_social_summary-default"
    );

    if ($generateSocial.length > 0) {
      $generateSocial.on("click", "a", function (event) {
        event.preventDefault();

        $modal.toggleClass("modal--visible");
        const $social = $(this).text();

        const $socialTexts = $modal.find(".modal__social");
        console.log("$socialTexts", $socialTexts);

        $socialTexts.each(function () {
          $(this).text($social);
        });
      });
    }
  });
})(jQuery);

(function ($) {
  "use strict";

  $(window).on("load", function () {
    let currentPageUrl = window.location.href;
    currentPageUrl = currentPageUrl.split('#')[0];
    const $modal = $("#social-sensei-modal");
    const socialMappings = {
      twitter: {
        url: "https://twitter.com/intent/tweet?url=" + currentPageUrl + "&text=",
      },
      linkedin: {
        url: "https://www.linkedin.com/shareArticle?mini=true&url=" + currentPageUrl + "&text=",
      },
    };

    if ($modal.length > 0) {
      const $modalClose = $modal.find("[data-modal-close]");

      $modalClose.each(function () {
        $(this).on("click", function () {
          $modal.removeClass("modal--visible");
        });
      });
    }

    $("#wp-admin-bar-social-sensei_social_summary-default").on(
      "click",
      "a",
      function (event) {
        event.preventDefault();
        const hrefValue = $(this).attr("href").substring(1);

        // use hrefValue to set share button text and href
        $('#social-sensei-share-li').attr('href', socialMappings[hrefValue].url);
        $('#social-sensei-share-li').text('Share to ' + hrefValue.toUpperCase());

        $modal.addClass("modal--visible");
        const $social = $(this).text();
        const $socialTexts = $modal.find(".modal__social");

        $socialTexts.each(function () {
          $(this).text($social);
        });

        const main = document.querySelector("main").innerHTML;
        const endpointUrl =
          window.socialSenseiAjax.ajax_url + "?action=wl_generate_summary";

        const postData = {
          data: main,
        };

        const fetchOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(postData),
        };

        fetch(endpointUrl, fetchOptions)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.json();
          })
          .then((data) => {
            const responseData = data.data.choices[0].message.content;
            $modal.find(".modal__body p").text(responseData);
            $("#social-sensei-share-li").attr("href", function (i, prevHref) {
              return prevHref + responseData;
            });
          })
          .catch((error) => {
            console.error("Fetch error:", error);
          });
      }
    );
  });
})(jQuery);

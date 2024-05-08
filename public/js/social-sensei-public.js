(function ($) {
  "use strict";

  $(window).on("load", function () {
    let currentPageUrl = window.location.href;
    currentPageUrl = currentPageUrl.split("#")[0];
    const $modal = $("#social-sensei-modal");
    let currentlySelectedSocial = '';
    const socialMappings = {
      facebook: {
        url: "https://www.facebook.com/sharer/sharer.php?u=" + currentPageUrl,
      },
      twitter: {
        url:
          "https://twitter.com/intent/tweet?url=" + currentPageUrl + "&text=",
      },
      linkedin: {
        url:
          "https://www.linkedin.com/shareArticle?mini=true&url=" +
          currentPageUrl +
          "&text=",
      },
    };

    function socialSenseiGetSummary(social) {
      currentlySelectedSocial = social;
      const formattedSocial = social.charAt(0).toUpperCase() + social.slice(1);
      $("#social-sensei-share-li").attr(
        "href",
        socialMappings[social].url
      );
      $("#social-sensei-share-li").text("Share to " + formattedSocial);
  
      $modal.addClass("modal--visible");
      const socialTexts = $modal.find(".modal__social");
  
      socialTexts.each(function () {
        $(this).text(formattedSocial);
      });
  
      if (formattedSocial === "Facebook") {
        $(".modal__instructions").innerHTML =
          'Copy the text then click the button below to share on <span class="modal__social">Facebook</span>.';
      }
  
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
          if (data.data.choices) {
            const responseData = data.data.choices[0].message.content;
            $modal.find(".modal__body p").text(responseData);
            $("#social-sensei-share-li").attr("href", function (i, prevHref) {
              let newHref =
                social === "Facebook" ? prevHref : prevHref + responseData;
              return newHref;
            });
          } else if (data.data.error) {
            $modal.find(".modal__body p").text("AI summary generation failed : " + data.data.error.message);
          }
        })
        .catch((error) => {
          console.error("Fetch error:", error);
        });
    }

    // handle copy button
    $("#modal__body--copy-button").on("click", async function () {
      var text = $(".modal__body p").text();

      try {
        await navigator.clipboard.writeText(text);
        $("#modal__body--copy-button svg.copy").hide();
        $("#modal__body--copy-button svg.check").fadeIn(200);
        $(".modal__body--help small").text("Copied!");

        setTimeout(function () {
          $("#modal__body--copy-button svg.check").fadeOut(200, function () {
            $(this).hide();
            $("#modal__body--copy-button svg.copy").fadeIn(200);
          });

          $(".modal__body--help small").text("");
        }, 1000);
      } catch (err) {
        $(".modal__body--help small").text("Failed to copy!");
      }
    });

    if ($modal.length > 0) {
      const $modalClose = $modal.find("[data-modal-close]");

      $modalClose.each(function () {
        $(this).on("click", function () {
          $modal.removeClass("modal--visible");
        });
      });
    }

    // handles initial summary generation
    $("#wp-admin-bar-social-sensei_social_summary-default").on(
      "click",
      "a",
      function (event) {
        event.preventDefault();
        const hrefValue = $(this).attr("href").substring(1);
        socialSenseiGetSummary(hrefValue);
      }
    );

    // handles summary re-generation
    $("#social-sensei-regenerate").on("click", function (event) {
      event.preventDefault();
      $modal.find(".modal__body p").text("Regenerating summary...");
      socialSenseiGetSummary(currentlySelectedSocial);
    });
  });
})(jQuery);

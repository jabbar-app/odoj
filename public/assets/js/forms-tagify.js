"use strict";

(function () {
    const TagifyCustomInlineSuggestionEl = document.querySelector(
        "#TagifyCustomInlineSuggestion"
    );

    if (TagifyCustomInlineSuggestionEl) {
        let whitelist = []; // Declare whitelist variable outside the fetch block

        // Fetch tags from the backend
        fetch("/articles/tags")
            .then((response) => response.json())
            .then((fetchedWhitelist) => {
                whitelist = fetchedWhitelist; // Assign fetched data to whitelist

                // Initialize Tagify with the fetched tags
                let TagifyCustomInlineSuggestion = new Tagify(
                    TagifyCustomInlineSuggestionEl,
                    {
                        whitelist: whitelist,
                        maxTags: 10,
                        dropdown: {
                            maxItems: 20,
                            classname: "tags-inline",
                            enabled: 0,
                            closeOnSelect: false,
                        },
                    }
                );
            })
            .catch((error) => console.error("Error fetching tags:", error));

        const TagifyCustomListSuggestionEl = document.querySelector(
            "#TagifyCustomListSuggestion"
        );

        // List
        let TagifyCustomListSuggestion = new Tagify(
            TagifyCustomListSuggestionEl,
            {
                whitelist: whitelist, // Use the same whitelist variable
                maxTags: 10,
                dropdown: {
                    maxItems: 20,
                    classname: "",
                    enabled: 0,
                    closeOnSelect: false,
                },
            }
        );
    }
})();

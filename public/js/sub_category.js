$(document).ready(function () {
    $(document).on("change", ".themeId", function () {
        var themeId = $(this).val();
        $(".categoryId").find("option").not(":first").remove();
        $.ajax({
            url: publicPath + "admin/ajax/getCategory",
            type: "POST",
            data: {
                theme_id: themeId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                themeId: themeId,
            },
            success: function (response) {
                $.each(response.categories, function (key, value) {
                    $(".categoryId").append(
                        $("<option/>", {
                            value: key,
                            text: value,
                        })
                    );
                });
            },
        });
    });

    $(document).on("change", ".categoryId", function () {
        var categoryId = $(this).val();
        $(".subCategoryId").find("option").not(":first").remove();
        $.ajax({
            url: publicPath + "admin/ajax/getSubCategory",
            type: "POST",
            data: {
                category_id: categoryId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                categoryId: categoryId,
            },
            success: function (response) {
                $.each(response.subcategories, function (key, value) {
                    $(".subCategoryId").append(
                        $("<option/>", {
                            value: key,
                            text: value,
                        })
                    );
                });
            },
        });
    });
});

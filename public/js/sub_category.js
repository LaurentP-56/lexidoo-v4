$(document).ready(function () {
    $(document).on("change", ".themeId", function () {
        var themeId = $(this).val();
        $(".categoryData").find("option").not(":first").remove();
        $.ajax({
            url: publicPath + "admin/sub_category/getCategory",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                themeId: themeId,
            },
            success: function (response) {
                var html = "";
                $.each(response.categories, function (key, value) {
                    $(".categoryData").append(
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

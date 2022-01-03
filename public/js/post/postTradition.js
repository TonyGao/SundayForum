$(function() {
    $(".paper.title textarea").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
      }).on("input", function () {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
      });
})
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.AspNetCore.Mvc.Routing;
using Microsoft.AspNetCore.Mvc.ViewFeatures;
using Microsoft.AspNetCore.Razor.TagHelpers;

namespace autobagaz
{
    public class PaginationTagHelper : TagHelper
    {
        private readonly IUrlHelperFactory urlHelperFactory;
        public PaginationTagHelper(IUrlHelperFactory helperFactory)
        {
            urlHelperFactory = helperFactory;
        }
        [ViewContext]
        [HtmlAttributeNotBound]
        public ViewContext ViewContext { get; set; }
        public Pagination Pagination { get; set; }
        public string PageAction { get; set; }
        public override void Process(TagHelperContext context, TagHelperOutput output)
        {
            IUrlHelper urlHelper = urlHelperFactory.GetUrlHelper(ViewContext);
            output.TagName = "div";

            // набор ссылок будет представлять div
            TagBuilder tag = new TagBuilder("div");
            tag.AddCssClass("pagination");
            
            for (int i = 1; i <= Pagination.TotalPages; i++)
            {
                TagBuilder currentItem = CreateTag(i, urlHelper);
                tag.InnerHtml.AppendHtml(currentItem);
            }
            
            output.Content.AppendHtml(tag);
        }
        TagBuilder CreateTag(int pageNumber, IUrlHelper urlHelper)
        {
            TagBuilder link = new TagBuilder("a");
            if (pageNumber == this.Pagination.PageNumber)
            {
                link.AddCssClass("pagination__link pagination__link--active");
            }
            else 
            {
                link.Attributes["href"] = urlHelper.Action(PageAction, new { page = pageNumber });
                link.AddCssClass("pagination__link");
            }
            link.InnerHtml.Append(pageNumber.ToString());
            return link;
        }
    }
}

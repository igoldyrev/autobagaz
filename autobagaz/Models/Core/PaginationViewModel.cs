using System.Collections.Generic;

namespace autobagaz
{
    public class PaginationViewModel
    {
       public IEnumerable<Shop> Shops { get; set; }
        public Pagination Pagination { get; set; }
    }
}

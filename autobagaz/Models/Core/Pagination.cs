using System;

namespace autobagaz
{
    /// <summary>
    /// Пагинация на странице
    /// </summary>
    public class Pagination
    {
        /// <summary>
        /// Номер текущей страницы
        /// </summary>
        public int PageNumber { get; private set; }
        /// <summary>
        /// Всего страниц
        /// </summary>
        public int TotalPages { get; private set; }
        public Pagination(int count, int pageNumber, int pageSize)
        {
            PageNumber = pageNumber;
            TotalPages = (int)Math.Ceiling(count / (double)pageSize);
        }
        /// <summary>
        /// Наличие предыдущей страницы
        /// </summary>
        public bool HasPreviousPage
        {
            get
            {
                return (PageNumber > 1);
            }
        }
        /// <summary>
        /// Наличие следующей страницы
        /// </summary>
        public bool HasNextPage
        {
            get
            {
                return (PageNumber < TotalPages);
            }
        }
    }
}

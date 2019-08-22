using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Город
    /// </summary>
    [Table("AUTOBAGAZ_CITY")]
    public class City
    {
        /// <summary>
        /// ИД города
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_CITY_ID { get; set; }
        /// <summary>
        /// Название города
        /// </summary>
        [Required]
        public string AUTOBAGAZ_CITY_NAME { get; set; }
        public ICollection<Shop> Shops { get; set; }
        public City()
        {
            Shops = new List<Shop>();
        }
    }
}

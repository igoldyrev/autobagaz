using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    [Table("AUTOBAGAZHIK")]
    public class Autobagazhnik
    {
        [Key]
        public int AUTOBAGAZHIK_ID { get; set; }
        public string AUTOBAGAZHIK_NAME { get; set; }
        public string AUTOBAGAZHIK_FILE_NAME { get; set; }
        public string AUTOBAGAZHIK_FILE_PATH { get; set; }
        public string AUTOBAGAZHIK_DESCRIPTION { get; set; }
    }
}

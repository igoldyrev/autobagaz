using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    [Table("AUTOBAGAZHIK_SHTATNYE")]
    public class AutobagazhnikShtatnye
    {
        [Key]
        public int AUTOBAGAZHIK_SHTATNYE_ID { get; set; }
        public string AUTOBAGAZHIK_SHTATNYE_NAME { get; set; }
        public string AUTOBAGAZHIK_SHTATNYE_FILE_NAME { get; set; }
        public string AUTOBAGAZHIK_SHTATNYE_FILE_PATH { get; set; }
        public string AUTOBAGAZHIK_SHTATNYE_DESCRIPTION { get; set; }
    }
}

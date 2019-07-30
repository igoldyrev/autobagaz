using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    [Table("AUTOBAGAZHIK_REELINGS")]
    public class AutobagazhnikReelings
    {
        [Key]
        public int AUTOBAGAZHIK_REELINGS_ID { get; set; }
        public string AUTOBAGAZHIK_REELINGS_NAME { get; set; }
        public string AUTOBAGAZHIK_REELINGS_FILE_NAME { get; set; }
        public string AUTOBAGAZHIK_REELINGS_FILE_PATH { get; set; }
        public string AUTOBAGAZHIK_REELINGS_DESCRIPTION { get; set; }
    }
}

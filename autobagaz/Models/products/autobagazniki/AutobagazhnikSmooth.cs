using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    [Table("AUTOBAGAZHIK_SMOOTH")]
    public class AutobagazhnikSmooth
    {
        [Key]
        public int AUTOBAGAZHIK_SMOOTH_ID { get; set; }
        public string AUTOBAGAZHIK_SMOOTH_NAME { get; set; }
        public string AUTOBAGAZHIK_SMOOTH_FILE_NAME { get; set; }
        public string AUTOBAGAZHIK_SMOOTH_FILE_PATH { get; set; }
        public string AUTOBAGAZHIK_SMOOTH_DESCRIPTION { get; set; }
    }
}

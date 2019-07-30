using Microsoft.EntityFrameworkCore;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace autobagaz.Models
{
    public class AutobagazContext : DbContext
    {
        public DbSet<User> Users { get; set; }

        public AutobagazContext(DbContextOptions<AutobagazContext> options)
            : base(options)
        {
            Database.Migrate();
        }
    }
}

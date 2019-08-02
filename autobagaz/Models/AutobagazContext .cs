﻿using Microsoft.EntityFrameworkCore;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace autobagaz.Models
{
    public class AutobagazContext : DbContext
    {
        public DbSet<AUTOBAGAZ_STATUS> AUTOBAGAZ_STATUS { get; set; }
        public DbSet<AUTOBAGAZ_ROLE> AUTOBAGAZ_ROLE { get; set; }
        public DbSet<AUTOBAGAZ_USER> AUTOBAGAZ_USER { get; set; }
        public DbSet<Autobagazhnik> Autobagazhnik { get; set; }
        public DbSet<AutobagazhnikReelings> AutobagazhnikReelings { get; set; }
        public DbSet<AutobagazhnikShtatnye> AutobagazhnikShtatnye { get; set; }
        public DbSet<AutobagazhnikSmooth> AutobagazhnikSmooth { get; set; }
        public DbSet<AutobagazhnikVodostok> AutobagazhnikVodostok { get; set; }

        public AutobagazContext(DbContextOptions<AutobagazContext> options)
            : base(options)
        {
            Database.Migrate();
        }
    }
}
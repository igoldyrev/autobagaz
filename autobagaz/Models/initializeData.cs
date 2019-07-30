using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace autobagaz.Models
{
    public static class initializeData
    {
        public static void Initialize(AutobagazContext context)
        {
            if (!context.Users.Any())
            {
                context.Users.AddRange(
                    new User
                    {
                        Id = 1,
                        Name = "Test",
                        Age = 2
                    });
                context.SaveChanges();
            }
        }
    }
}

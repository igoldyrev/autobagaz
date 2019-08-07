using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class DropWorktime : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_WORKTIME");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_WORKTIME",
                columns: table => new
                {
                    WORKTIME_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    WORKTIME_EMAIL = table.Column<string>(nullable: true),
                    WORKTIME_ENDTIME_WEEK = table.Column<string>(nullable: true),
                    WORKTIME_ENDTIME_WEEKEND = table.Column<string>(nullable: true),
                    WORKTIME_STARTTIME_WEEK = table.Column<string>(nullable: true),
                    WORKTIME_STARTTIME_WEEKEND = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_WORKTIME", x => x.WORKTIME_ID);
                });
        }
    }
}

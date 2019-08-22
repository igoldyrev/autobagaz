using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class ShopPerson : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON_PHONE");

            migrationBuilder.AddColumn<string>(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME",
                table: "AUTOBAGAZ_SHOP",
                nullable: true);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_PHONE",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON");
        }
    }
}

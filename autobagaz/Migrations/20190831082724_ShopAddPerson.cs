using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class ShopAddPerson : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_PHONE",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON_PHONE2");

            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON_PHONE1");

            migrationBuilder.AlterColumn<string>(
                name: "AUTOBAGAZ_SHOP_PHONE",
                table: "AUTOBAGAZ_SHOP",
                nullable: false,
                oldClrType: typeof(string),
                oldNullable: true);

            migrationBuilder.AlterColumn<string>(
                name: "AUTOBAGAZ_SHOP_NAME",
                table: "AUTOBAGAZ_SHOP",
                nullable: false,
                oldClrType: typeof(string),
                oldNullable: true);

            migrationBuilder.AddColumn<string>(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME1",
                table: "AUTOBAGAZ_SHOP",
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME2",
                table: "AUTOBAGAZ_SHOP",
                nullable: true);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME1",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_NAME2",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_PHONE2",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON_PHONE");

            migrationBuilder.RenameColumn(
                name: "AUTOBAGAZ_SHOP_PERSON_PHONE1",
                table: "AUTOBAGAZ_SHOP",
                newName: "AUTOBAGAZ_SHOP_PERSON_NAME");

            migrationBuilder.AlterColumn<string>(
                name: "AUTOBAGAZ_SHOP_PHONE",
                table: "AUTOBAGAZ_SHOP",
                nullable: true,
                oldClrType: typeof(string));

            migrationBuilder.AlterColumn<string>(
                name: "AUTOBAGAZ_SHOP_NAME",
                table: "AUTOBAGAZ_SHOP",
                nullable: true,
                oldClrType: typeof(string));
        }
    }
}

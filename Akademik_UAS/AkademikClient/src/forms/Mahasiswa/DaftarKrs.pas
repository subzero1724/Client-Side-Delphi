unit DaftarKrs;

interface

uses
  Winapi.Windows, Winapi.Messages,
  System.SysUtils, System.Variants, System.Classes,
  System.JSON,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Vcl.StdCtrls, Vcl.Grids,
  ApiClient;

type
  TFormDaftarKrs = class(TForm)
    Label1: TLabel;
    sgInputKRS: TStringGrid;
    sgViewKRS: TStringGrid;
    btnInput: TButton;
    btnHapus: TButton;
    btnRefresh: TButton;
    procedure FormCreate(Sender: TObject);
    procedure btnInputClick(Sender: TObject);
    procedure btnHapusClick(Sender: TObject);
    procedure btnRefreshClick(Sender: TObject);
    procedure sgInputKRSSelectCell(Sender: TObject; ACol, ARow: Integer;
      var CanSelect: Boolean);
    procedure sgViewKRSSelectCell(Sender: TObject; ACol, ARow: Integer;
      var CanSelect: Boolean);
  private
    procedure SetupGrid;
    procedure LoadMK;
    procedure AmbilMK;
  public
  end;

var
  FormDaftarKrs: TFormDaftarKrs;

implementation

{$R *.dfm}

{ ================= INIT ================= }

procedure TFormDaftarKrs.FormCreate(Sender: TObject);
begin
  SetupGrid;
  LoadMK;
end;

procedure TFormDaftarKrs.SetupGrid;
begin
  { === Grid Input (MK tersedia) === }
  sgInputKRS.ColCount := 5;
  sgInputKRS.RowCount := 2;
  sgInputKRS.FixedRows := 1;
  sgInputKRS.Options := sgInputKRS.Options + [goRowSelect];
  sgInputKRS.Cells[0,0] := 'ID';
  sgInputKRS.Cells[1,0] := 'Kode';
  sgInputKRS.Cells[2,0] := 'Nama';
  sgInputKRS.Cells[3,0] := 'SKS';
  sgInputKRS.Cells[4,0] := 'Dosen';
  sgInputKRS.ColWidths[0] := 0;

  { === Grid KRS mahasiswa === }
  sgViewKRS.ColCount := 5;
  sgViewKRS.RowCount := 2;
  sgViewKRS.FixedRows := 1;
  sgViewKRS.Options := sgViewKRS.Options + [goRowSelect];
  sgViewKRS.Cells[0,0] := 'ID';
  sgViewKRS.Cells[1,0] := 'Kode';
  sgViewKRS.Cells[2,0] := 'Nama';
  sgViewKRS.Cells[3,0] := 'SKS';
  sgViewKRS.Cells[4,0] := 'Dosen';
  sgViewKRS.ColWidths[0] := 0;

  btnInput.Enabled := False;
  btnHapus.Enabled := False;
end;

{ ================= LOAD MK ================= }

procedure TFormDaftarKrs.LoadMK;
var
  Res: TJSONObject;
  Arr: TJSONArray;
  Obj: TJSONObject;
  i: Integer;
begin
  Res := TApiClient.Get('/mahasiswa/list_mk.php');
  if Res = nil then Exit;

  Arr := Res.GetValue<TJSONArray>('data');
  if Arr = nil then Exit;

  sgInputKRS.RowCount := Arr.Count + 1;

  for i := 0 to Arr.Count - 1 do
  begin
    Obj := Arr.Items[i] as TJSONObject;
    sgInputKRS.Cells[0,i+1] := Obj.GetValue('id_matakuliah').Value;
    sgInputKRS.Cells[1,i+1] := Obj.GetValue('kode_mk').Value;
    sgInputKRS.Cells[2,i+1] := Obj.GetValue('nama_mk').Value;
    sgInputKRS.Cells[3,i+1] := Obj.GetValue('sks').Value;
    sgInputKRS.Cells[4,i+1] := Obj.GetValue('nama_dosen').Value;
  end;
end;

{ ================= LOGIC ================= }

procedure TFormDaftarKrs.AmbilMK;
var
  r: Integer;
  Body, Res, MataKuliah: TJSONObject;
begin
  r := sgInputKRS.Row;
  if r = 0 then Exit;

  Body := TJSONObject.Create;
  try
    Body.AddPair('id_matakuliah', sgInputKRS.Cells[0,r]);
    Res := TApiClient.Post('/mahasiswa/ambil_mk.php', Body);

    if (Res = nil) or (Res.GetValue('status').Value <> 'true') then
    begin
      ShowMessage(Res.GetValue('message').Value);
      Exit;
    end;

    MataKuliah := Res.GetValue<TJSONObject>('data').GetValue<TJSONObject>('mata_kuliah');

    sgViewKRS.RowCount := sgViewKRS.RowCount + 1;
    sgViewKRS.Cells[0, sgViewKRS.RowCount-1] := MataKuliah.GetValue('id_matakuliah').Value;
    sgViewKRS.Cells[1, sgViewKRS.RowCount-1] := MataKuliah.GetValue('kode_mk').Value;
    sgViewKRS.Cells[2, sgViewKRS.RowCount-1] := MataKuliah.GetValue('nama_mk').Value;
    sgViewKRS.Cells[3, sgViewKRS.RowCount-1] := MataKuliah.GetValue('sks').Value;
    sgViewKRS.Cells[4, sgViewKRS.RowCount-1] := MataKuliah.GetValue('nama_dosen').Value;

    ShowMessage('MK berhasil diambil');
  finally
    Body.Free;
  end;
end;

{ ================= GRID ================= }

procedure TFormDaftarKrs.sgInputKRSSelectCell(Sender: TObject; ACol,
  ARow: Integer; var CanSelect: Boolean);
begin
  CanSelect := ARow > 0;
  btnInput.Enabled := CanSelect;
end;

procedure TFormDaftarKrs.sgViewKRSSelectCell(Sender: TObject; ACol,
  ARow: Integer; var CanSelect: Boolean);
begin
  CanSelect := ARow > 0;
  btnHapus.Enabled := CanSelect;
end;

{ ================= BUTTON ================= }

procedure TFormDaftarKrs.btnInputClick(Sender: TObject);
begin
  AmbilMK;
end;

procedure TFormDaftarKrs.btnHapusClick(Sender: TObject);
begin
//  if sgViewKRS.Row > 0 then
//    sgViewKRS.DeleteRow(sgViewKRS.Row);
end;

procedure TFormDaftarKrs.btnRefreshClick(Sender: TObject);
begin
  SetupGrid;
  LoadMK;
end;

end.


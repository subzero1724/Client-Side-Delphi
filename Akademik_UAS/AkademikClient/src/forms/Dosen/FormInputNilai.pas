unit FormInputNilai;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, System.JSON, Vcl.Graphics, Vcl.Controls, Vcl.Forms,
  Vcl.Dialogs, Vcl.ExtCtrls, Vcl.StdCtrls, ApiClient;

type
  TFormNilaiDosen = class(TForm)
    GroupBox1: TGroupBox;
    Label1: TLabel;
    cbMataKuliah: TComboBox;
    Label2: TLabel;
    cbMahasiswa: TComboBox;
    btnSimpan: TButton;
    GroupBox2: TGroupBox;
    Label3: TLabel;
    edtUts: TEdit;
    Label4: TLabel;
    edtUAS: TEdit;
    Label5: TLabel;
    edtTugas: TEdit;
    Label8: TLabel;
    edtQuis: TEdit;
    Label6: TLabel;
    Label7: TLabel;
    Panel1: TPanel;
    edtGrade: TEdit;
    btnRefresh: TButton;
    procedure FormShow(Sender: TObject);
    procedure cbMataKuliahChange(Sender: TObject);
    procedure edtUtsChange(Sender: TObject);
    procedure edtUASChange(Sender: TObject);
    procedure edtTugasChange(Sender: TObject);
    procedure edtQuisChange(Sender: TObject);
    procedure btnSimpanClick(Sender: TObject);
    procedure btnRefreshClick(Sender: TObject);
  private
    procedure LoadMataKuliah;
    procedure LoadMahasiswa(idMK: string);
    procedure HitungGrade;
  public
  end;

var
  FormNilaiDosen: TFormNilaiDosen;

implementation

{$R *.dfm}

{ ================= INIT ================= }

procedure TFormNilaiDosen.FormShow(Sender: TObject);
begin
  cbMataKuliah.Clear;
  cbMahasiswa.Clear;
  edtUts.Clear;
  edtUAS.Clear;
  edtTugas.Clear;
  edtQuis.Clear;
  edtGrade.Clear;

  LoadMataKuliah;
end;

{ ================= LOAD MATA KULIAH ================= }

procedure TFormNilaiDosen.LoadMataKuliah;
var
  Res: TJSONObject;
  Arr: TJSONArray;
  Obj: TJSONObject;
  i: Integer;
begin
  cbMataKuliah.Items.Clear;
  cbMataKuliah.ItemIndex := -1;

  Res := TApiClient.Get('/dosen/mk_saya.php');
  if Res = nil then Exit;

  if (Res.GetValue('status').Value <> 'true') then Exit;

  Arr := Res.GetValue<TJSONArray>('data');
  if Arr = nil then Exit;

  for i := 0 to Arr.Count - 1 do
  begin
    Obj := Arr.Items[i] as TJSONObject;

    cbMataKuliah.Items.AddObject(
      Obj.GetValue('nama_mk').AsType<string> + ' (' + Obj.GetValue('kode_mk').AsType<string> + ')',
      TObject(StrToInt(Obj.GetValue('id_matakuliah').AsType<string>))
    );
  end;

  if cbMataKuliah.Items.Count > 0 then
    cbMataKuliah.ItemIndex := 0;

  if cbMataKuliah.ItemIndex <> -1 then
    LoadMahasiswa(IntToStr(Integer(cbMataKuliah.Items.Objects[cbMataKuliah.ItemIndex])));
end;

{ ================= LOAD MAHASISWA ================= }

procedure TFormNilaiDosen.LoadMahasiswa(idMK: string);
var
  Res: TJSONObject;
  Arr: TJSONArray;
  Obj: TJSONObject;
  i: Integer;
begin
  cbMahasiswa.Items.Clear;
  cbMahasiswa.ItemIndex := -1;

  Res := TApiClient.Get('/dosen/mahasiswa_kelas.php?id_matakuliah=' + idMK);
  if (Res = nil) or (Res.GetValue('status').Value <> 'true') then Exit;

  Arr := Res.GetValue<TJSONArray>('data');
  if Arr = nil then Exit;

  for i := 0 to Arr.Count - 1 do
  begin
    Obj := Arr.Items[i] as TJSONObject;
    cbMahasiswa.Items.AddObject(
      Obj.GetValue('nama').AsType<string> + ' [' + Obj.GetValue('nim').AsType<string> + ']',
      TObject(StrToInt(Obj.GetValue('id_mahasiswa').AsType<string>))
    );
  end;

  if cbMahasiswa.Items.Count > 0 then
    cbMahasiswa.ItemIndex := 0;
end;

{ ================= EVENT COMBOBOX ================= }

procedure TFormNilaiDosen.cbMataKuliahChange(Sender: TObject);
var
  idMK: string;
begin
  if cbMataKuliah.ItemIndex = -1 then Exit;
  idMK := IntToStr(Integer(cbMataKuliah.Items.Objects[cbMataKuliah.ItemIndex]));
  LoadMahasiswa(idMK);
end;

procedure TFormNilaiDosen.edtUtsChange(Sender: TObject);
begin
  HitungGrade;
end;

procedure TFormNilaiDosen.edtUASChange(Sender: TObject);
begin
  HitungGrade;
end;

procedure TFormNilaiDosen.edtTugasChange(Sender: TObject);
begin
  HitungGrade;
end;

procedure TFormNilaiDosen.edtQuisChange(Sender: TObject);
begin
  HitungGrade;
end;

{ ================= HITUNG GRADE ================= }

procedure TFormNilaiDosen.HitungGrade;
var
  total: Double;
begin
  total := StrToFloatDef(edtTugas.Text,0)*0.20 +
           StrToFloatDef(edtQuis.Text,0)*0.20 +
           StrToFloatDef(edtUts.Text,0)*0.25 +
           StrToFloatDef(edtUAS.Text,0)*0.35;

  if total >= 85 then edtGrade.Text := 'A'
  else if total >= 75 then edtGrade.Text := 'B'
  else if total >= 65 then edtGrade.Text := 'C'
  else if total >= 50 then edtGrade.Text := 'D'
  else edtGrade.Text := 'E';
end;

{ ================= BUTTON REFRESH ================= }

procedure TFormNilaiDosen.btnRefreshClick(Sender: TObject);
begin
  LoadMataKuliah;
end;

{ ================= SIMPAN NILAI ================= }

procedure TFormNilaiDosen.btnSimpanClick(Sender: TObject);
var
  idMK, idMhs: string;
  Body: TJSONObject;
  Res: TJSONObject;
begin
  if cbMataKuliah.ItemIndex = -1 then
  begin
    ShowMessage('Pilih mata kuliah dulu');
    Exit;
  end;

  if cbMahasiswa.ItemIndex = -1 then
  begin
    ShowMessage('Pilih mahasiswa dulu');
    Exit;
  end;

  idMK  := IntToStr(Integer(cbMataKuliah.Items.Objects[cbMataKuliah.ItemIndex]));
  idMhs := IntToStr(Integer(cbMahasiswa.Items.Objects[cbMahasiswa.ItemIndex]));

  HitungGrade;

  Body := TJSONObject.Create;
  try
    // Kirim id_mahasiswa & id_matakuliah, API akan resolve id_krs
    Body.AddPair('id_mahasiswa', idMhs);
    Body.AddPair('id_matakuliah', idMK);
    Body.AddPair('tugas', TJSONNumber.Create(StrToFloatDef(edtTugas.Text,0)));
    Body.AddPair('kuis', TJSONNumber.Create(StrToFloatDef(edtQuis.Text,0)));
    Body.AddPair('uts', TJSONNumber.Create(StrToFloatDef(edtUts.Text,0)));
    Body.AddPair('uas', TJSONNumber.Create(StrToFloatDef(edtUAS.Text,0)));

    Res := TApiClient.Post('/dosen/input_nilai.php', Body);

    if (Res <> nil) and (Res.GetValue('status').Value = 'true') then
      ShowMessage('Nilai berhasil disimpan')
    else if Res <> nil then
      ShowMessage('Gagal menyimpan nilai: ' + Res.GetValue('message').Value)
    else
      ShowMessage('Gagal menyimpan nilai: Response kosong');

  finally
    Body.Free;
  end;
end;

end.


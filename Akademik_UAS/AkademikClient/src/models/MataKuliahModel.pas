unit MataKuliahModel;

interface

uses
  System.JSON;

type
  TMataKuliah = class
  public
    IdMataKuliah : Integer;
    KodeMK       : string;
    NamaMK       : string;
    SKS          : Integer;
    NamaDosen    : string;

    constructor CreateFromJSON(Json: TJSONObject);
  end;

implementation

constructor TMataKuliah.CreateFromJSON(Json: TJSONObject);
begin
  if Json = nil then Exit;

  IdMataKuliah := Json.GetValue('id_matakuliah').AsType<Integer>;
  KodeMK       := Json.GetValue('kode_mk').Value;
  NamaMK       := Json.GetValue('nama_mk').Value;
  SKS          := Json.GetValue('sks').AsType<Integer>;

  if Json.GetValue('nama_dosen') <> nil then
    NamaDosen := Json.GetValue('nama_dosen').Value
  else
    NamaDosen := '-';
end;

end.


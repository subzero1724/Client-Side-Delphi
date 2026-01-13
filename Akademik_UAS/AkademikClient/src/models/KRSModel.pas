unit KRSModel;

interface

uses
  System.JSON;

type
  TKRS = class
  public
    IdKRS       : Integer;
    NamaMK      : string;
    SKS         : Integer;
    NamaDosen  : string;

    constructor CreateFromJSON(Json: TJSONObject);
  end;

implementation

constructor TKRS.CreateFromJSON(Json: TJSONObject);
begin
  if Json = nil then Exit;

  IdKRS      := Json.GetValue('id_krs').AsType<Integer>;
  NamaMK    := Json.GetValue('nama_mk').Value;
  SKS       := Json.GetValue('sks').AsType<Integer>;
  NamaDosen := Json.GetValue('nama_dosen').Value;
end;

end.


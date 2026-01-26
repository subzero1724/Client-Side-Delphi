unit DosenModel;

interface

uses
  System.JSON, ApiClient;

type
  TDosenModel = class
  public
    class function GetAll: TJSONArray;
    class function Insert(NIDN, Nama, Password: string): Boolean;
    class function Update(NIDN, Nama: string): Boolean;
    class function Delete(NIDN: string): Boolean;
  end;

implementation

class function TDosenModel.GetAll: TJSONArray;
var
  Res: TJSONObject;
begin
  Res := TApiClient.Get('/admin/dosen_read.php');
  Result := Res.GetValue('data') as TJSONArray;
end;

class function TDosenModel.Insert(NIDN, Nama, Password: string): Boolean;
var
  Body, Res: TJSONObject;
begin
  Body := TJSONObject.Create;
  try
    Body.AddPair('nidn', NIDN);
    Body.AddPair('nama', Nama);
    Body.AddPair('password', Password);

    Res := TApiClient.Post('/admin/dosen_create.php', Body);
    Result := Res.GetValue('status').AsType<Boolean>;
  finally
    Body.Free;
  end;
end;

class function TDosenModel.Update(NIDN, Nama: string): Boolean;
var
  Body, Res: TJSONObject;
begin
  Body := TJSONObject.Create;
  try
    Body.AddPair('nidn', NIDN);
    Body.AddPair('nama', Nama);

    Res := TApiClient.Post('/admin/dosen_update.php', Body);
    Result := Res.GetValue('status').AsType<Boolean>;
  finally
    Body.Free;
  end;
end;

class function TDosenModel.Delete(NIDN: string): Boolean;
var
  Body, Res: TJSONObject;
begin
  Body := TJSONObject.Create;
  try
    Body.AddPair('nidn', NIDN);

    Res := TApiClient.Post('/admin/dosen_delete.php', Body);
    Result := Res.GetValue('status').AsType<Boolean>;
  finally
    Body.Free;
  end;
end;

end.


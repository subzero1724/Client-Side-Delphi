unit UserModel;

interface

uses
  System.JSON;

type
  TUser = class
  public
    IdUser   : Integer;
    Username : string;
    Role     : string;
    Token    : string;

    constructor CreateFromJSON(Json: TJSONObject);
  end;

implementation

constructor TUser.CreateFromJSON(Json: TJSONObject);
begin
  if Json = nil then Exit;

  if Json.GetValue('id_user') <> nil then
    IdUser := Json.GetValue('id_user').AsType<Integer>;

  if Json.GetValue('username') <> nil then
    Username := Json.GetValue('username').Value;

  if Json.GetValue('role') <> nil then
    Role := Json.GetValue('role').Value;

  if Json.GetValue('token') <> nil then
    Token := Json.GetValue('token').Value;
end;

end.


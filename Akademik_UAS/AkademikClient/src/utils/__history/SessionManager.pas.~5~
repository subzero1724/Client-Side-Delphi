unit SessionManager;

interface

type
  TSessionManager = class
  private
    class var FToken: string;
    class var FRole: string;
    class var FUsername: string;
  public
    class procedure SetSession(AToken, ARole, AUsername: string);
    class procedure ClearSession;

    class function GetToken: string;
    class function GetRole: string;
    class function GetUsername: string;
    class function IsLoggedIn: Boolean;
end;

implementation

class procedure TSessionManager.SetSession(
  AToken, ARole, AUsername: string
);
begin
  FToken := AToken;
  FRole := ARole;
  FUsername := AUsername;
end;

class procedure TSessionManager.ClearSession;
begin
  FToken := '';
  FRole := '';
  FUsername := '';
end;

class function TSessionManager.GetToken: string;
begin
  Result := FToken;
end;

class function TSessionManager.GetRole: string;
begin
  Result := FRole;
end;

class function TSessionManager.GetUsername: string;
begin
  Result := FUsername;
end;

class function TSessionManager.IsLoggedIn: Boolean;
begin
  Result := FToken <> '';
end;

end.

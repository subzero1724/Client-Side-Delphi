unit ApiClient;

interface

uses
  System.SysUtils, System.Classes,
  System.JSON,
  System.Net.URLClient,
  System.Net.HttpClient,
  System.Net.HttpClientComponent,
  Vcl.Dialogs,
  AppConfig, SessionManager;

type
  TApiClient = class
  public
    class function Get(const Endpoint: string): TJSONObject;
    class function Post(const Endpoint: string; Body: TJSONObject): TJSONObject;
  end;

implementation

{ ================= GET ================= }

class function TApiClient.Get(const Endpoint: string): TJSONObject;
var
  Client   : TNetHTTPClient;
  Response : IHTTPResponse;
  Url      : string;
begin
  Result := nil;
  Client := TNetHTTPClient.Create(nil);
  try
    Url := BASE_URL + Endpoint;

    Client.ConnectionTimeout := 5000;
    Client.ResponseTimeout   := 5000;
    Client.ContentType       := 'application/json';

    if TSessionManager.IsLoggedIn then
      Client.CustomHeaders['Authorization'] :=
        'Bearer ' + TSessionManager.GetToken;

    // 🔥 DEBUG
    ShowMessage('GET REQUEST:' + sLineBreak + Url);

    Response := Client.Get(Url);

    ShowMessage(
      'HTTP STATUS: ' + Response.StatusCode.ToString + sLineBreak +
      'RESPONSE:' + sLineBreak +
      Response.ContentAsString
    );

    if Response.StatusCode <> 200 then
      raise Exception.Create('HTTP Error ' + Response.StatusCode.ToString);

    Result := TJSONObject.ParseJSONValue(
      Response.ContentAsString
    ) as TJSONObject;

  except
    on E: Exception do
      ShowMessage('GET ERROR: ' + E.Message);
  end;
  Client.Free;
end;

{ ================= POST ================= }

class function TApiClient.Post(const Endpoint: string; Body: TJSONObject): TJSONObject;
var
  Client   : TNetHTTPClient;
  Response : IHTTPResponse;
  Content  : TStringStream;
  Url      : string;
begin
  Result := nil;
  Client := TNetHTTPClient.Create(nil);
  Content := nil;
  try
    Url := BASE_URL + Endpoint;

    Client.ContentType := 'application/json';

    if TSessionManager.IsLoggedIn then
      Client.CustomHeaders['Authorization'] :=
        'Bearer ' + TSessionManager.GetToken;

    Content := TStringStream.Create(Body.ToJSON, TEncoding.UTF8);

    // 🔥 DEBUG
    ShowMessage('POST REQUEST:' + sLineBreak + Url);

    Response := Client.Post(Url, Content);

    ShowMessage(
      'HTTP STATUS: ' + Response.StatusCode.ToString + sLineBreak +
      'RESPONSE:' + sLineBreak +
      Response.ContentAsString
    );

    if Response.StatusCode <> 200 then
      raise Exception.Create('HTTP Error ' + Response.StatusCode.ToString);

    Result := TJSONObject.ParseJSONValue(
      Response.ContentAsString
    ) as TJSONObject;

  except
    on E: Exception do
      ShowMessage('POST ERROR: ' + E.Message);
  end;

  Content.Free;
  Client.Free;
end;

end.


unit AppConfig;

interface

var
  BASE_URL: string;

procedure SetBaseURL(IP: string);

implementation

procedure SetBaseURL(IP: string);
begin
  // pastikan format selalu http://IP/Client-Side-Delphi
  BASE_URL := 'http://' + IP + '/Client-Side-Delphi';
end;

end.


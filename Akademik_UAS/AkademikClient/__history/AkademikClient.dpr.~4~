program AkademikClient;

uses
  Vcl.Forms,
  FormLogin in 'src\forms\FormLogin.pas' {FrmLogin},
  FormAdmin in 'src\forms\FormAdmin.pas' {FrmAdmin},
  FormMahasiswa in 'src\forms\FormMahasiswa.pas' {FrmMahasiswa},
  FormDosen in 'src\forms\FormDosen.pas' {FrmDosen},
  FormMK in 'src\forms\FormMK.pas' {FrmMK},
  ApiClient in 'src\utils\ApiClient.pas',
  SessionManager in 'src\utils\SessionManager.pas',
  AppConfig in 'src\utils\AppConfig.pas',
  UserModel in 'src\models\UserModel.pas',
  MataKuliahModel in 'src\models\MataKuliahModel.pas',
  KRSModel in 'src\models\KRSModel.pas';

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;

  // ✅ HANYA LOGIN
  Application.CreateForm(TFrmLogin, FrmLogin);
  Application.Run;
end.


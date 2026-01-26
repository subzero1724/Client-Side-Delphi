program AkademikClient;

uses
  Vcl.Forms,
  FormLogin in 'src\forms\FormLogin.pas' {FrmLogin},
  FormAdmin in 'src\forms\FormAdmin.pas' {FrmAdmin},
  FormMahasiswaAdmin in 'src\forms\FormMahasiswaAdmin.pas' {FrmMahasiswaAdmin},
  FormDosenAdmin in 'src\forms\FormDosenAdmin.pas' {FrmDosenAdmin},
  FormMK in 'src\forms\FormMK.pas' {FrmMK},
  ApiClient in 'src\utils\ApiClient.pas',
  SessionManager in 'src\utils\SessionManager.pas',
  AppConfig in 'src\utils\AppConfig.pas',
  UserModel in 'src\models\UserModel.pas',
  MataKuliahModel in 'src\models\MataKuliahModel.pas',
  KRSModel in 'src\models\KRSModel.pas',
  DosenModel in 'src\models\DosenModel.pas',
  DaftarKrs in 'src\forms\Mahasiswa\DaftarKrs.pas' {FormDaftarKrs};

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;

  // ✅ HANYA LOGIN
  Application.CreateForm(TFrmLogin, FrmLogin);
  Application.CreateForm(TFormDaftarKrs, FormDaftarKrs);
  Application.Run;
end.


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
  DaftarKrs in 'src\forms\Mahasiswa\DaftarKrs.pas' {FormDaftarKrs},
  FormInputNilai in 'src\forms\Dosen\FormInputNilai.pas' {Form2},
  FormLihatNilai in 'src\forms\Mahasiswa\FormLihatNilai.pas' {Form3},
  MainMenuMahasiswa in 'src\forms\Mahasiswa\MainMenuMahasiswa.pas' {Form1},
  IPForm in 'src\forms\IPForm.pas' {Form4};

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;

  // ✅ HANYA LOGIN
  Application.CreateForm(TFrmLogin, FrmLogin);
  Application.CreateForm(TFormDaftarKrs, FormDaftarKrs);
  Application.CreateForm(TForm2, Form2);
  Application.CreateForm(TForm3, Form3);
  Application.CreateForm(TForm1, Form1);
  Application.CreateForm(TForm4, Form4);
  Application.Run;
end.


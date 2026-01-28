object FormNilaiDosen: TFormNilaiDosen
  Left = 0
  Top = 0
  Caption = 'FormNilaiDosen'
  ClientHeight = 544
  ClientWidth = 519
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object GroupBox1: TGroupBox
    Left = 24
    Top = 24
    Width = 457
    Height = 425
    Caption = 'Form Penilaian'
    TabOrder = 0
    object Label1: TLabel
      Left = 88
      Top = 136
      Width = 82
      Height = 13
      Caption = 'Nama Mahasiswa'
    end
    object Label6: TLabel
      Left = 170
      Top = 40
      Width = 103
      Height = 13
      Caption = 'Input Nilai Mahasiswa'
    end
    object Label2: TLabel
      Left = 88
      Top = 86
      Width = 58
      Height = 13
      Caption = 'Mata Kuliah '
    end
    object btnSimpan: TButton
      Left = 72
      Top = 344
      Width = 137
      Height = 49
      Caption = 'Simpan'
      TabOrder = 0
      OnClick = btnSimpanClick
    end
    object GroupBox2: TGroupBox
      Left = 72
      Top = 176
      Width = 329
      Height = 153
      Caption = 'Input Nilai'
      TabOrder = 1
      object Label5: TLabel
        Left = 40
        Top = 116
        Width = 20
        Height = 13
        Caption = 'UAS'
      end
      object Label4: TLabel
        Left = 40
        Top = 84
        Width = 19
        Height = 13
        Caption = 'UTS'
      end
      object Label3: TLabel
        Left = 40
        Top = 36
        Width = 29
        Height = 13
        Caption = 'Tugas'
      end
      object Label7: TLabel
        Left = 264
        Top = 32
        Width = 29
        Height = 13
        Caption = 'Grade'
      end
      object Label8: TLabel
        Left = 40
        Top = 55
        Width = 21
        Height = 13
        Caption = 'Quis'
      end
      object edtUts: TEdit
        Left = 104
        Top = 81
        Width = 121
        Height = 21
        TabOrder = 0
      end
      object edtUAS: TEdit
        Left = 104
        Top = 108
        Width = 121
        Height = 21
        TabOrder = 1
      end
      object edtTugas: TEdit
        Left = 104
        Top = 33
        Width = 121
        Height = 21
        TabOrder = 2
      end
      object Panel1: TPanel
        Left = 248
        Top = 61
        Width = 65
        Height = 60
        TabOrder = 3
      end
      object edtGrade: TEdit
        AlignWithMargins = True
        Left = 263
        Top = 70
        Width = 34
        Height = 37
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clWindowText
        Font.Height = -24
        Font.Name = 'Tahoma'
        Font.Style = [fsBold]
        ParentFont = False
        ReadOnly = True
        TabOrder = 4
      end
      object edtQuis: TEdit
        Left = 104
        Top = 54
        Width = 121
        Height = 21
        TabOrder = 5
      end
    end
    object cbMahasiswa: TComboBox
      Left = 248
      Top = 133
      Width = 117
      Height = 21
      TabOrder = 2
      Text = 'cbMahasiswa'
    end
    object cbMataKuliah: TComboBox
      Left = 248
      Top = 83
      Width = 117
      Height = 21
      TabOrder = 3
      Text = 'cbMataKuliah'
    end
    object btnRefresh: TButton
      Left = 248
      Top = 344
      Width = 153
      Height = 49
      Caption = 'Refresh'
      TabOrder = 4
      OnClick = btnRefreshClick
    end
  end
end

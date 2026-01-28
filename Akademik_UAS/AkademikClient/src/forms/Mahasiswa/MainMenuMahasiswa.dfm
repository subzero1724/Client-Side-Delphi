object MainForm: TMainForm
  Left = 0
  Top = 0
  Caption = 'MainForm'
  ClientHeight = 519
  ClientWidth = 808
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  Menu = MainMenu1
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object pnlContent: TPanel
    Left = 0
    Top = 0
    Width = 808
    Height = 519
    Align = alClient
    BevelOuter = bvNone
    Caption = 'pnlContent'
    TabOrder = 0
    ExplicitLeft = 368
    ExplicitTop = 352
    ExplicitWidth = 185
    ExplicitHeight = 41
  end
  object MainMenu1: TMainMenu
    Left = 280
    Top = 208
    object LihatNilai1: TMenuItem
      Caption = 'Lihat Nilai'
      OnClick = LihatNilai1Click
    end
    object BuatKRS1: TMenuItem
      Caption = 'Buat KRS'
      OnClick = BuatKRS1Click
    end
  end
end

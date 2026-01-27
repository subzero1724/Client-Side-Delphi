object Form4: TForm4
  Left = 0
  Top = 0
  Caption = 'Form4'
  ClientHeight = 733
  ClientWidth = 866
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
    Left = 176
    Top = 160
    Width = 465
    Height = 353
    Caption = 'Config'
    TabOrder = 0
    object Label1: TLabel
      Left = 116
      Top = 143
      Width = 55
      Height = 13
      Caption = 'Masukan Ip'
    end
    object Label2: TLabel
      Left = 116
      Top = 76
      Width = 228
      Height = 25
      Caption = 'Input IP Yang Di Tuju'
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -21
      Font.Name = 'Tahoma'
      Font.Style = [fsBold]
      ParentFont = False
    end
    object Edit1: TEdit
      Left = 186
      Top = 140
      Width = 121
      Height = 21
      TabOrder = 0
    end
    object Button1: TButton
      Left = 160
      Top = 200
      Width = 137
      Height = 65
      Caption = 'Masuk'
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -27
      Font.Name = 'Tahoma'
      Font.Style = []
      ParentFont = False
      TabOrder = 1
      OnClick = Button1Click
    end
  end
end

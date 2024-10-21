using System;
using System.IO;
using System.Windows.Forms;
using AwariGame;

namespace Beadando1
{
    public partial class Awari : Form
    {
        private MenuStrip? menuStrip;
        private ToolStripMenuItem? _menuFile;
        private ToolStripMenuItem? _menuFileNewGame;
        private ToolStripSeparator? toolStripSeparator1;
        private ToolStripMenuItem? _menuFileLoadGame;
        private ToolStripMenuItem? _menuFileSaveGame;
        private ToolStripSeparator? toolStripSeparator2;
        private ToolStripMenuItem? _menuFileExit;
        private ToolStripMenuItem? _menuSettings;
        private ToolStripMenuItem? _menuGameEasy;
        private ToolStripMenuItem? _menuGameMedium;
        private ToolStripMenuItem? _menuGameHard;
        private ToolStripSeparator? toolStripSeparator3;
        private ToolStripSeparator? toolStripSeparator4;
        private Label? label1;
        private Label? label2;
        private Label? label3;
        private Form2? gameForm;

        #region Constrcutor
        public Awari()
        {
            InitializeComponent();

        }
        #endregion

        #region SpecialInitialize
        private void InitializeComponent()
        {
            menuStrip = new MenuStrip();
            _menuFile = new ToolStripMenuItem();
            _menuFileNewGame = new ToolStripMenuItem();
            toolStripSeparator1 = new ToolStripSeparator();
            _menuFileLoadGame = new ToolStripMenuItem();
            _menuFileSaveGame = new ToolStripMenuItem();
            toolStripSeparator2 = new ToolStripSeparator();
            _menuFileExit = new ToolStripMenuItem();
            _menuSettings = new ToolStripMenuItem();
            _menuGameEasy = new ToolStripMenuItem();
            toolStripSeparator3 = new ToolStripSeparator();
            _menuGameMedium = new ToolStripMenuItem();
            toolStripSeparator4 = new ToolStripSeparator();
            _menuGameHard = new ToolStripMenuItem();
            label1 = new Label();
            label2 = new Label();
            label3 = new Label();
            menuStrip.SuspendLayout();
            SuspendLayout();
            // 
            // menuStrip
            // 
            menuStrip.ImageScalingSize = new Size(32, 32);
            menuStrip.Items.AddRange(new ToolStripItem[] { _menuFile, _menuSettings });
            menuStrip.Location = new Point(0, 0);
            menuStrip.Name = "menuStrip";
            menuStrip.Size = new Size(1974, 42);
            menuStrip.TabIndex = 0;
            menuStrip.Text = "menuStrip1";
            // 
            // _menuFile
            // 
            _menuFile.DropDownItems.AddRange(new ToolStripItem[] { _menuFileNewGame, toolStripSeparator1, _menuFileLoadGame, _menuFileSaveGame, toolStripSeparator2, _menuFileExit });
            _menuFile.Name = "_menuFile";
            _menuFile.Size = new Size(71, 38);
            _menuFile.Text = "File";
            // 
            // _menuFileNewGame
            // 
            _menuFileNewGame.Name = "_menuFileNewGame";
            _menuFileNewGame.Size = new Size(359, 44);
            _menuFileNewGame.Text = "New Game";
            _menuFileNewGame.Click += _menuFileNewGame_Click;
            // 
            // toolStripSeparator1
            // 
            toolStripSeparator1.Name = "toolStripSeparator1";
            toolStripSeparator1.Size = new Size(356, 6);
            // 
            // _menuFileLoadGame
            // 
            _menuFileLoadGame.Name = "_menuFileLoadGame";
            _menuFileLoadGame.Size = new Size(359, 44);
            _menuFileLoadGame.Text = "Load Game";
            _menuFileLoadGame.Click += _menuFileLoadGame_Click;
            // 
            // _menuFileSaveGame
            // 
            _menuFileSaveGame.Name = "_menuFileSaveGame";
            _menuFileSaveGame.Size = new Size(359, 44);
            _menuFileSaveGame.Text = "Save Game";
            _menuFileSaveGame.Click += _menuFileSaveGame_Click;
            // 
            // toolStripSeparator2
            // 
            toolStripSeparator2.Name = "toolStripSeparator2";
            toolStripSeparator2.Size = new Size(356, 6);
            // 
            // _menuFileExit
            // 
            _menuFileExit.Name = "_menuFileExit";
            _menuFileExit.Size = new Size(359, 44);
            _menuFileExit.Text = "Exit";
            _menuFileExit.Click += _menuFileExit_Click;
            // 
            // _menuSettings
            // 
            _menuSettings.DropDownItems.AddRange(new ToolStripItem[] { _menuGameEasy, toolStripSeparator3, _menuGameMedium, toolStripSeparator4, _menuGameHard });
            _menuSettings.Name = "_menuSettings";
            _menuSettings.Size = new Size(120, 38);
            _menuSettings.Text = "Settings";
            // 
            // _menuGameEasy
            // 
            _menuGameEasy.Name = "_menuGameEasy";
            _menuGameEasy.Size = new Size(274, 44);
            _menuGameEasy.Text = "Easy - 4";
            _menuGameEasy.Click += _menuGameEasy_Click;
            // 
            // toolStripSeparator3
            // 
            toolStripSeparator3.Name = "toolStripSeparator3";
            toolStripSeparator3.Size = new Size(271, 6);
            // 
            // _menuGameMedium
            // 
            _menuGameMedium.Name = "_menuGameMedium";
            _menuGameMedium.Size = new Size(274, 44);
            _menuGameMedium.Text = "Medium - 6";
            _menuGameMedium.Click += _menuGameMedium_Click;
            // 
            // toolStripSeparator4
            // 
            toolStripSeparator4.Name = "toolStripSeparator4";
            toolStripSeparator4.Size = new Size(271, 6);
            // 
            // _menuGameHard
            // 
            _menuGameHard.Name = "_menuGameHard";
            _menuGameHard.Size = new Size(274, 44);
            _menuGameHard.Text = "Hard - 8";
            _menuGameHard.Click += _menuGameHard_Click;
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Font = new Font("Segoe UI Black", 19.875F, FontStyle.Bold, GraphicsUnit.Point, 0);
            label1.ForeColor = Color.Red;
            label1.Location = new Point(840, 281);
            label1.Name = "label1";
            label1.Size = new Size(299, 71);
            label1.TabIndex = 1;
            label1.Text = "WELCOME";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Font = new Font("Segoe UI Black", 19.875F, FontStyle.Bold, GraphicsUnit.Point, 0);
            label2.ForeColor = Color.FromArgb(0, 192, 192);
            label2.Location = new Point(870, 451);
            label2.Name = "label2";
            label2.Size = new Size(220, 71);
            label2.TabIndex = 2;
            label2.Text = "AWARI";
            // 
            // label3
            // 
            label3.AutoSize = true;
            label3.Font = new Font("Segoe UI Black", 19.875F, FontStyle.Bold, GraphicsUnit.Point, 0);
            label3.ForeColor = Color.Black;
            label3.Location = new Point(939, 362);
            label3.Name = "label3";
            label3.Size = new Size(86, 71);
            label3.TabIndex = 3;
            label3.Text = "to";
            // 
            // Awari
            // 
            ClientSize = new Size(1974, 829);
            Controls.Add(label3);
            Controls.Add(label2);
            Controls.Add(label1);
            Controls.Add(menuStrip);
            MainMenuStrip = menuStrip;
            Name = "Awari";
            menuStrip.ResumeLayout(false);
            menuStrip.PerformLayout();
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        #region FileNewGame
        private void _menuFileNewGame_Click(object? sender, EventArgs e)
        {
            if (gameForm != null)
            {
                gameForm.Close();
            }

            StartNewGameWithDifficulty(4);
        }

        #endregion

        #region FileExitApp
        private void _menuFileExit_Click(object? sender, EventArgs e)
        {
            Application.Exit();
        }
        #endregion

        #region GameEasy
        private void _menuGameEasy_Click(object? sender, EventArgs e)
        {
            StartNewGameWithDifficulty(4);
        }
        #endregion

        #region GameMedium
        private void _menuGameMedium_Click(object? sender, EventArgs e)
        {
            StartNewGameWithDifficulty(6);
        }
        #endregion

        #region GameHard
        private void _menuGameHard_Click(object? sender, EventArgs e)
        {
            StartNewGameWithDifficulty(8);
        }
        #endregion

        #region NewGameWithDificulty
        private void StartNewGameWithDifficulty(int numberOfPits)
        {
            label1!.Visible = false;
            label2!.Visible = false;
            label3!.Visible = false;

            if (gameForm != null)
            {
                Controls.Remove(gameForm);
                gameForm.Dispose();
            }

            gameForm = new Form2(numberOfPits);
            gameForm.TopLevel = false;
            gameForm.FormBorderStyle = FormBorderStyle.None;
            gameForm.Dock = DockStyle.None;

            gameForm.Size = new Size(((numberOfPits + 2) * 160) + ((numberOfPits + 2) * 20), 430);

            gameForm.Location = new Point((this.ClientSize.Width - gameForm.Width) / 2,
                                          (this.ClientSize.Height - gameForm.Height) / 2);

            Controls.Add(gameForm);
            gameForm.Show();
        }

        #endregion

        #region GameSave
        private void _menuFileSaveGame_Click(object? sender, EventArgs e)
        {
            using (SaveFileDialog saveFileDialog = new SaveFileDialog())
            {
                saveFileDialog.Filter = "Text files (*.txt)|*.txt";
                if (saveFileDialog.ShowDialog() == DialogResult.OK)
                {
                    SaveGame(saveFileDialog.FileName);
                }
            }
        }

        private void SaveGame(string filePath)
        {
            using (StreamWriter writer = new StreamWriter(filePath))
            {
                int[] pits = gameForm!.GameModel.Pits;
                int player1Store = gameForm.GameModel.Player1Store;
                int player2Store = gameForm.GameModel.Player2Store;

                writer.WriteLine(string.Join(",", pits));

                writer.WriteLine($"{player1Store},{player2Store}");

            }
        }
        #endregion

        #region GameLoad
        private void _menuFileLoadGame_Click(object? sender, EventArgs e)
        {
            using (OpenFileDialog openFileDialog = new OpenFileDialog())
            {
                openFileDialog.Filter = "Text files (*.txt)|*.txt";
                if (openFileDialog.ShowDialog() == DialogResult.OK)
                {
                    LoadGame(openFileDialog.FileName);
                }
            }
        }

        private void LoadGame(string filePath)
        {
            using (StreamReader reader = new StreamReader(filePath))
            {
                try
                {
                    string pitsLine = reader.ReadLine()!;
                    if (pitsLine != null)
                    {
                        int[] pits = Array.ConvertAll(pitsLine.Split(','), int.Parse);

                        label1!.Visible = false;
                        label2!.Visible = false;
                        label3!.Visible = false;

                        if (gameForm != null)
                        {
                            gameForm.Close();
                        }

                        gameForm = new Form2(pits.Length / 2);
                        gameForm.TopLevel = false;
                        gameForm.FormBorderStyle = FormBorderStyle.None;
                        gameForm.Dock = DockStyle.None;

                        gameForm.Size = new Size(((pits.Length / 2 + 2) * 160) + ((pits.Length / 2 + 2) * 20), 430);

                        gameForm.Location = new Point((this.ClientSize.Width - gameForm.Width) / 2,
                                                        (this.ClientSize.Height - gameForm.Height) / 2);
                        Controls.Add(gameForm);
                        gameForm.GameModel.Pits = pits;
                    }

                    string storesLine = reader.ReadLine()!;
                    if (storesLine != null)
                    {
                        string[] stores = storesLine.Split(',');
                        
                        gameForm!.GameModel.Player1Store = int.Parse(stores[0]);
                        gameForm!.GameModel.Player2Store = int.Parse(stores[1]);
                    }

                    gameForm!.OnBoardChanged(this, EventArgs.Empty);
                    gameForm.Show();
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Error loading game: {ex.Message}");
                }
            }
        }
        #endregion
    }
}

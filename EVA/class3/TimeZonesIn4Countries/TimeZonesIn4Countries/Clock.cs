using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace TimeZonesIn4Countries
{
    public partial class Clock : UserControl
    {
        private System.Windows.Forms.Timer timer;
        private int timeZone;

        public string City
        {
            get => cityLabel.Text;
            set => cityLabel.Text = value;
        }
        public int TimeZone
        {
            get { return timeZone; }
            set
            {
                timeZone = value;
                RefreshTime(this, EventArgs.Empty);
            }
        }
        public Clock()
        {
            InitializeComponent();

            timer = new System.Windows.Forms.Timer();
            timer.Interval = 1000;
            timer.Tick += RefreshTime;
            timer.Start();
        }

        private void RefreshTime(object sender, EventArgs e)
        {
            DateTime time = DateTime.Now;
            timeLabel.Text = time
            .AddHours(TimeZone)
            .ToString(time.Second % 2 == 0 ? "HH:mm" : "HH mm");
        }
    }
}

package cmd

import (
	"fmt"
	"log"

	"github.com/spf13/cobra"
	"github.com/spf13/viper"

	"github.com/ktom/sibebe/php"
	"github.com/ktom/sibebe/sibebe"
	"github.com/ktom/sibebe/utils"
)

var cfgFile string

// rootCmd represents the base command when called without any subcommands
var rootCmd = &cobra.Command{
	Use:   "sibebe",
	Short: "Manage the monolith",
	Long: `Sibebe is a cli application that aims to simplify working
with multiples packages, projects, frameworks and languages in a
single VCS repository.`,
	// Uncomment the following line if your bare application
	// has an action associated with it:
	// Run: func(cmd *cobra.Command, args []string) { },
}

// Execute adds all child commands to the root command and sets flags appropriately.
// This is called by main.main(). It only needs to happen once to the rootCmd.
func Execute() {
	cobra.CheckErr(rootCmd.Execute())
}

func init() {
	cobra.OnInitialize(initConfig, initSibebe)

	// Here you will define your flags and configuration settings.
	// Cobra supports persistent flags, which, if defined here,
	// will be global for your application.

	rootCmd.PersistentFlags().StringVar(&cfgFile, "config", "", "config file (default is $HOME/.sibebe.yaml)")
	rootCmd.PersistentFlags().BoolP("verbose", "v", false, "display more info")
	viper.BindPFlag("verbose", rootCmd.PersistentFlags().Lookup("verbose"))

	// Cobra also supports local flags, which will only run
	// when this action is called directly.
	rootCmd.Flags().BoolP("toggle", "t", false, "Help message for toggle")
}

func initSibebe() {
    viperConfig := viper.GetViper()

    config := new(sibebe.SibebeViperConfig)
    config.Setup(viperConfig)

    collector := sibebe.LanguagePackFactoriesCollector{}
    collector.AddFactory("php", php.GetFactory())

    sibebe.Setup(config, collector)
}

func initConfig() {
    execDir := utils.GetExecDir()

	if cfgFile != "" {
		// Use config file from the flag.
		viper.SetConfigFile(cfgFile)
	} else {
		viper.AddConfigPath(execDir)
		viper.SetConfigName(".sibebe")
	}

    viper.SetConfigType("yaml")
	viper.SetEnvPrefix("SIBEBE")
    viper.AutomaticEnv()

	// If a config file is found, read it in.
	err := viper.ReadInConfig()
	if err != nil {
	    log.Fatal(err)
	}

    if viper.GetBool("verbose") {
        fmt.Println("Using config file: "+ viper.ConfigFileUsed())
    }
}

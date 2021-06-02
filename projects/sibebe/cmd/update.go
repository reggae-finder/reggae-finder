package cmd

import (
	"fmt"
	"log"

	"github.com/spf13/cobra"

	"github.com/ktom/sibebe/sibebe"
)

var updateCmd = &cobra.Command{
	Use: "update [-v|--verbose]",
	Short: "Update dependencies of each packages",
	Long: `Long desc`,
	Run: func(cmd *cobra.Command, args []string) {
		if err := sibebe.Update(); err != nil {
			log.Fatal(err)
		}
		fmt.Println("Command update done successfully")
	},
}

func init() {
	rootCmd.AddCommand(updateCmd)
}

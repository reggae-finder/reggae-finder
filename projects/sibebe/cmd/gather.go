package cmd

import (
    _"fmt"
    "log"
    "github.com/spf13/cobra"

    "github.com/ktom/sibebe/sibebe"
)

var gatherCmd = &cobra.Command{
    Use: "gather [-i|--install] [-v|--verbose]",
    Short: "Gather dependencies from all packages",
    Long: `Long desc`,
    Run: func(cmd *cobra.Command, args []string) {
        if err := sibebe.Gather(); err != nil {
            log.Fatal(err)
        }

        install, err := cmd.Flags().GetBool("install")
        if err != nil { log.Fatal(err) }

        if install {
            if installErr := sibebe.GlobalInstall(); installErr != nil {
                log.Fatal(installErr)
            }
        }
    },
}

func init() {
	rootCmd.AddCommand(gatherCmd)

	gatherCmd.Flags().BoolP("install", "i", false, "install dependencies globally")
}

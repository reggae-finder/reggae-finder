package cmd

import (
    "log"
    "github.com/spf13/cobra"

    "github.com/ktom/sibebe/sibebe"
)

var gatherCmd = &cobra.Command{
    Use: "gather",
    Short: "Gather dependencies from all packages",
    Long: `Long desc`,
    Run: func(cmd *cobra.Command, args []string) {
        if err := sibebe.Gather(); err != nil {
            log.Fatal(err)
        }
    },
}

func init() {
	rootCmd.AddCommand(gatherCmd)
}

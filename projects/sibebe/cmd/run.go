package cmd

import (
    "fmt"
    "log"

    "github.com/spf13/cobra"

    "github.com/ktom/sibebe/sibebe"
)

var runCmd = &cobra.Command{
    Use: "run [-v|--verbose]",
    Short: "Run actions for each packages",
    Long: `Long desc`,
    Run: func(cmd *cobra.Command, args []string) {
        clear, err := cmd.Flags().GetBool("clear-after")
        if err != nil { log.Fatal(err) }

        if err := sibebe.Run(clear); err != nil {
            log.Fatal(err)
        }
        fmt.Println("Command run done successfully!")
    },
}

func init() {
	rootCmd.AddCommand(runCmd)

    runCmd.Flags().BoolP("clear-after", "c", false, "clear after running")
}

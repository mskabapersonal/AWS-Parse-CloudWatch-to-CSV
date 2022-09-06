set dimensions=PercentageDiskSpaceUsed ReadIOPS TotalTableCount WriteIOPS CPUUtilization
set namespace=AWS/Redshift
set start_time=2022-03-16T00:00:00Z
set end_time=2022-03-20T00:00:00Z
set period=3600
set dimensionName=ClusterIdentifier
set statistics=Average

(for %%a in (%dimensions%) do (
   echo running %%a
    aws cloudwatch get-metric-statistics --metric-name %%a --start-time %start_time% --end-time %end_time% --period %period% -namespace %namespace% --statistics %statistics% --dimensions Name=%dimension%,Value=%1 --profile wd --region us-west-2 --output json > %1.%%a.json
)) 

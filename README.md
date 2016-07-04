
# Setup
## AWS
- S3
    - Create S3 bucket
    - Assign policy for cloudfront
- CloudFront
    - Link to S3 bucket
- EC2
    - Setup EC2 role
    - Apache2
    - PHP5
    - PHP Composer
    - git
- CodeDeploy
- RDS

## Software
- Setup src/config.php
- Install package from php composer

# Reference
## Role
### CloudFront
```
{
	"Version": "2008-10-17",
	"Id": "PolicyForCloudFrontPrivateContent",
	"Statement": [
		{
			"Sid": "1",
			"Effect": "Allow",
			"Principal": {
				"AWS": "arn:aws:iam::cloudfront:user/CloudFront Origin Access Identity ABCDEFGHIJKL"
			},
			"Action": "s3:GetObject",
			"Resource": "arn:aws:s3:::demo-/*"
		}
	]
}
```
### EC2
```
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "s3:*",
            "Resource": [
                "arn:aws:s3:::demo*",
                "arn:aws:s3:::aws-codedeploy*"
            ]
        }
    ]
}
``` 
### CodeDeploy
```
{
}
```

## SQL
```
CREATE DATABASE demo;
USE demo;
CREATE TABLE register (
    name VARCHAR(100),
    mail VARCHAR (200),
    pic VARCHAR(100)
) ENGINE=InnoDB;
```
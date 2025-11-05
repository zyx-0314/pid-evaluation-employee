#!/bin/bash

# Initialize LocalStack services to simulate AWS
# This script runs when LocalStack container starts

echo "Initializing LocalStack services..."

# Wait for LocalStack to be ready
sleep 10

# Create S3 bucket for employee documents and evaluations
awslocal s3 mb s3://pid-evaluation-documents
awslocal s3 mb s3://pid-evaluation-reports

# Set bucket policies (make them accessible)
awslocal s3api put-bucket-acl --bucket pid-evaluation-documents --acl public-read
awslocal s3api put-bucket-acl --bucket pid-evaluation-reports --acl public-read

echo "S3 buckets created: pid-evaluation-documents, pid-evaluation-reports"

# Note: API Gateway setup would typically be done via AWS SAM or Terraform
# For this simulation, the backend service will handle API routing

echo "LocalStack initialization complete!"
